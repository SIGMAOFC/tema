<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Pterodactyl;
use App\Events\UserUpdateCreditsEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\DynamicNotification;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{

    private Pterodactyl $pterodactyl;

    public function __construct(Pterodactyl $pterodactyl)
    {
        $this->pterodactyl = $pterodactyl;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        return view('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View|Response
     */
    public function show(User $user)
    {
        //QUERY ALL REFERRALS A USER HAS
        //i am not proud of this at all.
        $allReferals = [];
        $referrals = DB::table('user_referrals')
            ->where('referral_id', '=', $user->id)
            ->get();
        foreach ($referrals as $referral) {
            array_push($allReferals, $allReferals['id'] = User::query()->findOrFail($referral->registered_user_id));
        }
        array_pop($allReferals);

        switch ($user->role) {
            case 'client':
                $badgeColor = 'text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500';
                break;
            case 'admin':
                $badgeColor = 'text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-500';
                break;
            case 'moderator':
                $badgeColor = 'text-indigo-700 bg-indigo-100 dark:bg-indigo-500/20 dark:text-indigo-500';
                break;
            default:
                $badgeColor = 'text-purple-700 bg-purple-100 dark:bg-purple-700 dark:text-purple-100';
                break;
        }

        return view('admin.users.show')->with([
            'user' => $user,
            'referrals' => $allReferals,
            'badgeColor' => $badgeColor,
        ]);
    }

    /**
     * Get a JSON response of users.
     *
     * @return \Illuminate\Support\Collection|\App\models\User
     */
    public function json(Request $request)
    {
        $users = QueryBuilder::for(User::query())
            ->allowedFilters(['id', 'name', 'pterodactyl_id', 'email'])
            ->paginate(25);

        if ($request->query('user_id')) {
            $user = User::query()->findOrFail($request->input('user_id'));
            $user->avatarUrl = $user->getAvatar();

            return $user;
        }

        return $users->map(function ($item) {
            $item->avatarUrl = $item->getAvatar();

            return $item;
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return Application|Factory|View|Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')->with([
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:30',
            'pterodactyl_id' => "required|numeric|unique:users,pterodactyl_id,{$user->id}",
            'email' => 'required|string|email',
            'credits' => 'required|numeric|min:0|max:99999999',
            'server_limit' => 'required|numeric|min:0|max:1000000',
            'role' => Rule::in(['admin', 'moderator', 'client', 'member']),
            'referral_code' => "required|string|min:2|max:32|unique:users,referral_code,{$user->id}",
        ]);

        if (isset($this->pterodactyl->getUser($request->input('pterodactyl_id'))['errors'])) {
            throw ValidationException::withMessages([
                'pterodactyl_id' => [__("User does not exists on pterodactyl's panel")],
            ]);
        }

        if (!is_null($request->input('new_password'))) {
            $request->validate([
                'new_password' => 'required|string|min:8',
                'new_password_confirmation' => 'required|same:new_password',
            ]);

            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
        }

        $user->update($request->all());
        event(new UserUpdateCreditsEvent($user));

        return redirect()->route('admin.users.index')->with('success', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', __('user has been removed!'));
    }

    /**
     * Verifys the users email
     *
     * @param  User  $user
     * @return RedirectResponse
     */
    public function verifyEmail(Request $request, User $user)
    {
        $user->verifyEmail();

        return redirect()->back()->with('success', __('Email has been verified!'));
    }

    /**
     * @param  Request  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function loginAs(Request $request, User $user)
    {
        $request->session()->put('previousUser', Auth::user()->id);
        Auth::login($user);

        return redirect()->route('home');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function logBackIn(Request $request)
    {
        Auth::loginUsingId($request->session()->get('previousUser'), true);
        $request->session()->remove('previousUser');

        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for seding notifications to the specified resource.
     *
     * @param  User  $user
     * @return Application|Factory|View|Response
     */
    public function notifications(User $user)
    {
        return view('admin.users.notifications');
    }

    /**
     * Notify the specified resource.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function notify(Request $request)
    {
        $data = $request->validate([
            'via' => 'required|min:1|array',
            'via.*' => 'required|string|in:mail,database',
            'all' => 'required_without:users|boolean',
            'users' => 'required_without:all|min:1|array',
            'users.*' => 'exists:users,id',
            'title' => 'required|string|min:1',
            'content' => 'required|string|min:1',
        ]);

        $mail = null;
        $database = null;
        if (in_array('database', $data['via'])) {
            $database = [
                'title' => $data['title'],
                'content' => $data['content'],
            ];
        }
        if (in_array('mail', $data['via'])) {
            $mail = (new MailMessage)
                ->subject($data['title'])
                ->line(new HtmlString($data['content']));
        }
        $all = $data['all'] ?? false;
        $users = $all ? User::all() : User::whereIn('id', $data['users'])->get();
        Notification::send($users, new DynamicNotification($data['via'], $database, $mail));

        return redirect()->route('admin.users.notifications')->with('success', __('Notification sent!'));
    }

    /**
     * @param  User  $user
     * @return RedirectResponse
     */
    public function toggleSuspended(User $user)
    {
        try {
            !$user->isSuspended() ? $user->suspend() : $user->unSuspend();
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('success', __('User has been updated!'));
    }

    /**
     * @throws Exception
     */
    public function dataTable(Request $request)
    {
        $query =  User::with('discordUser')->withCount('servers');
        // manually count referrals in user_referrals table
        $query->selectRaw('users.*, (SELECT COUNT(*) FROM user_referrals WHERE user_referrals.referral_id = users.id) as referrals_count');

        
        return datatables($query)
            ->addColumn('avatar', function (User $user) {
                return '
                
                <div class="relative  w-8 h-8 mr-3 rounded-full">
                            <img class="object-cover w-full h-full rounded-full" src="' .
                    $user->getAvatar() .
                    '" alt="user avatar" loading="lazy">
                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                          </div>';
            })
            ->addColumn('credits', function (User $user) {
                return '<i class="fas fa-coins mr-2"></i> ' . $user->credits();
            })
            ->addColumn('verified', function (User $user) {
                return $user->getVerifiedStatus();
            })
            ->addColumn('discordId', function (User $user) {
                return $user->discordUser ? $user->discordUser->id : '';
            })
            ->addColumn('actions', function (User $user) {
                $suspendColor = $user->isSuspended() ? 'btn-success' : 'btn-warning';
                $suspendIcon = $user->isSuspended() ? 'fa-play-circle' : 'fa-pause-circle';
                $suspendText = $user->isSuspended() ? __('Unsuspend') : __('Suspend');
                return '
                       <div class="flex items-center text-sm">
                       <a data-content="' .
                    __('Login as User') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.users.loginas', $user->id) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Login as User">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                          </a>

                       <a data-content="' .
                    __('Verify') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.users.verifyEmail', $user->id) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Verify">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                          </a>

                       <a data-content="' .
                    __('Edit') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.users.edit', $user->id) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                          </a>
                        <form class="d-inline" method="post" action="' .
                    route('admin.users.togglesuspend', $user->id) .
                    '">
                          ' .
                    csrf_field() .
                    '
                       <button data-content="' .
                    __($suspendText) .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-yellow-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Suspend">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                          </button>
                          </form>
                          <form class="d-inline" onsubmit="return submitResult();" method="post" action="' .
                    route('admin.users.destroy', $user->id) .
                    '">
                          ' .
                    csrf_field() .
                    '
                          ' .
                    method_field('DELETE') .
                    '
                       <button data-content="' .
                    __('Delete') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                          </button>
                          </form>
                          </div>
                    
                ';
            })
            ->editColumn('role', function (User $user) {
                switch ($user->role) {
                    case 'client':
                        $badgeColor = 'text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500';
                        break;
                    case 'admin':
                        $badgeColor = 'text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-500';
                        break;
                    case 'moderator':
                        $badgeColor = 'text-indigo-700 bg-indigo-100 dark:bg-indigo-500/20 dark:text-indigo-500';
                        break;
                    default:
                        $badgeColor = 'text-purple-700 bg-purple-100 dark:bg-purple-700 dark:text-purple-100';
                        break;
                }

                return '<span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full ' . $badgeColor . '">' . $user->role . '</span>';
            })

            ->editColumn('last_seen', function (User $user) {
                return $user->last_seen ? $user->last_seen->diffForHumans() : __('Never');
            })
            ->editColumn('name', function (User $user) {
                return '<a class="font-medium text-purple-600 dark:text-purple-500 hover:underline" href="' . route('admin.users.show', $user->id) . '">' . strip_tags($user->name) . '</a> (<a class="font-medium text-purple-600 dark:text-purple-500 hover:underline" target="_blank" href="' . config('SETTINGS::SYSTEM:PTERODACTYL:URL') . '/admin/users/view/' . $user->pterodactyl_id . '">Pterodactyl</a>)';
            })
            ->rawColumns(['avatar', 'name', 'credits', 'role', 'usage', 'actions'])
            ->make();
    }
}
