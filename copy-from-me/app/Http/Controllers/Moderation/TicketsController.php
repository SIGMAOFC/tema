<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Models\Ticket;
use App\Models\TicketBlacklist;
use App\Models\TicketCategory;
use App\Models\TicketComment;
use App\Models\User;
use App\Notifications\Ticket\User\ReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = Ticket::orderBy('id', 'desc')->paginate(10);
        $ticketcategories = TicketCategory::all();

        return view('moderator.ticket.index', compact('tickets', 'ticketcategories'));
    }

    public function show($ticket_id)
    {
        try {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        } catch (Exception $e)
        {
            return redirect()->back()->with('warning', __('Ticket not found on the server. It potentially got deleted earlier'));
        }
        $ticketcomments = $ticket->ticketcomments;
        $ticketcategory = $ticket->ticketcategory;
        $server = Server::where('id', $ticket->server)->first();

        return view('moderator.ticket.show', compact('ticket', 'ticketcategory', 'ticketcomments', 'server'));
    }

    public function changeStatus($ticket_id)
    {
        try {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        } catch(Exception $e)
        {
            return redirect()->back()->with('warning', __('Ticket not found on the server. It potentially got deleted earlier'));
        }

        if($ticket->status == "Closed"){
            $ticket->status = "Reopened";
            $ticket->save();
            return redirect()->back()->with('success', __('A ticket has been reopened, ID: #') . $ticket->ticket_id);
        }
        $ticket->status = 'Closed';
        $ticket->save();
        $ticketOwner = $ticket->user;

        return redirect()->back()->with('success', __('A ticket has been closed, ID: #').$ticket->ticket_id);
    }

    public function delete($ticket_id)
    {
        try {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        } catch (Exception $e)
        {
            return redirect()->back()->with('warning', __('Ticket not found on the server. It potentially got deleted earlier'));
        }

        TicketComment::where('ticket_id', $ticket->id)->delete();
        $ticket->delete();

        return redirect()->back()->with('success', __('A ticket has been deleted, ID: #').$ticket_id);
    }

    public function reply(Request $request)
    {
        $this->validate($request, ['ticketcomment' => 'required']);
        try {
            $ticket = Ticket::where('id', $request->input('ticket_id'))->firstOrFail();
        } catch (Exception $e){
            return redirect()->back()->with('warning', __('Ticket not found on the server. It potentially got deleted earlier'));
        }
        $ticket->status = 'Answered';
        $ticket->update();
        TicketComment::create([
            'ticket_id' => $request->input('ticket_id'),
            'user_id' => Auth::user()->id,
            'ticketcomment' => $request->input('ticketcomment'),
        ]);
        try {
        $user = User::where('id', $ticket->user_id)->firstOrFail();
        } catch(Exception $e)
        {
            return redirect()->back()->with('warning', __('User not found on the server. Check on the admin database or try again later.'));
        }
        $newmessage = $request->input('ticketcomment');
        $user->notify(new ReplyNotification($ticket, $user, $newmessage));

        return redirect()->back()->with('success', __('Your comment has been submitted'));
    }

    public function dataTable()
    {
        $query = Ticket::query();

        return datatables($query)
            ->addColumn('category', function (Ticket $tickets) {
                return $tickets->ticketcategory->name;
            })
            ->editColumn('title', function (Ticket $tickets) {
                return '<a class="text-purple-600 underline"  href="' . route('moderator.ticket.show', ['ticket_id' => $tickets->ticket_id]) . '">' . '#' . $tickets->ticket_id . ' - ' . htmlspecialchars($tickets->title) . '</a>';
            })
            ->editColumn('user_id', function (Ticket $tickets) {
                return '<a class="text-purple-600 underline" href="' . route('admin.users.show', $tickets->user->id) . '">' . $tickets->user->name . '</a>';
            })
            ->addColumn('actions', function (Ticket $tickets) {
                $statusButtonColor = ($tickets->status == "Closed") ? 'btn-success' : 'btn-warning';
                $statusButtonIcon = ($tickets->status == "Closed") ? 'fa-redo' : 'fa-times';
                $statusButtonText = ($tickets->status == "Closed") ? __('Reopen') : __('Close');

                return '

  <div class="flex items-center text-sm">
    <a data-content="' .
                    __('Show') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('moderator.ticket.show', ['ticket_id' => $tickets->ticket_id]) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Login as User">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>        </a>

    <form class="d-inline"  method="post" action="' .
                    route('moderator.ticket.changeStatus', ['ticket_id' => $tickets->ticket_id]) .
                    '">
            ' .
                    csrf_field() .
                    '
            ' .
                    method_field('POST') .
                    '
    <button data-content="'.__($statusButtonText).
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Verify">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </button>
    </form>

        </form>
        <form class="d-inline"  method="post" action="' .
                    route('moderator.ticket.delete', ['ticket_id' => $tickets->ticket_id]) .
                    '">
        ' .
                    csrf_field() .
                    '
        ' .
                    method_field('POST') .
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
            ->editColumn('status', function (Ticket $tickets) {
                switch ($tickets->status) {
                    case 'Reopened':
                    case 'Open':
                        $badgeColor = 'text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500';
                        break;
                    case 'Closed':
                        $badgeColor = 'text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-500';
                        break;
                    case 'Answered':
                        $badgeColor = 'text-indigo-700 bg-indigo-100 dark:bg-indigo-500/20 dark:text-indigo-500';
                        break;
                    default:
                        $badgeColor = 'text-yellow-700 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-500';
                        break;
                }

                return '<span class="px-2 py-1 font-semibold leading-tight rounded-full text-xs ' . $badgeColor . '">' . $tickets->status . '</span>';
            })
            ->editColumn('priority', function (Ticket $tickets) {
                return __($tickets->priority);
            })
            ->editColumn('updated_at', function (Ticket $tickets) {
                return ['display' => $tickets->updated_at ? $tickets->updated_at->diffForHumans() : '', 'raw' => $tickets->updated_at ? strtotime($tickets->updated_at) : ''];
            })
            ->rawColumns(['category', 'title', 'user_id', 'status', 'priority', 'updated_at', 'actions'])
            ->make(true);
    }

    public function blacklist()
    {
        return view('moderator.ticket.blacklist');
    }

    public function blacklistAdd(Request $request)
    {
        try {
        $user = User::where('id', $request->user_id)->firstOrFail();
        $check = TicketBlacklist::where('user_id', $user->id)->first();
        }
        catch (Exception $e){
            return redirect()->back()->with('warning', __('User not found on the server. Check the admin database or try again later.'));
        }
        if ($check) {
            $check->reason = $request->reason;
            $check->status = 'True';
            $check->save();

            return redirect()->back()->with('info', __('Target User already in blacklist. Reason updated'));
        }
        TicketBlacklist::create([
            'user_id' => $user->id,
            'status' => 'True',
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', __('Successfully add User to blacklist, User name: '.$user->name));
    }

    public function blacklistDelete($id)
    {
        $blacklist = TicketBlacklist::where('id', $id)->first();
        $blacklist->delete();

        return redirect()->back()->with('success', __('Successfully remove User from blacklist, User name: '.$blacklist->user->name));
    }

    public function blacklistChange($id)
    {
        try {
            $blacklist = TicketBlacklist::where('id', $id)->first();
        }
        catch (Exception $e){
            return redirect()->back()->with('warning', __('User not found on the server. Check the admin database or try again later.'));
        }
        if ($blacklist->status == 'True') {
            $blacklist->status = 'False';
        } else {
            $blacklist->status = 'True';
        }
        $blacklist->update();

        return redirect()->back()->with('success', __('Successfully change status blacklist from, User name: '.$blacklist->user->name));
    }

    public function dataTableBlacklist()
    {
        $query = TicketBlacklist::with(['user']);
        $query->select('ticket_blacklists.*');
        return datatables($query)
            ->editColumn('user', function (TicketBlacklist $blacklist) {
                return '<a data-content="' . __('Show') . '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' . route('admin.users.show', $blacklist->user->id) . '">' . $blacklist->user->name . '</a>';
            })
            ->editColumn('status', function (TicketBlacklist $blacklist) {
                switch ($blacklist->status) {
                    case 'True':
                        $text = 'Blocked';
                        $badgeColor = 'badge-danger';
                        break;
                    default:
                        $text = 'Unblocked';
                        $badgeColor = 'badge-success';
                        break;
                }

                return '<span class="badge ' . $badgeColor . '">' . $text . '</span>';
            })
            ->editColumn('reason', function (TicketBlacklist $blacklist) {
                return $blacklist->reason;
            })
            ->addColumn('actions', function (TicketBlacklist $blacklist) {
                return '
                <div class=" flex items-center space-x-4 text-sm">
                            
        <form class="d-inline"  method="post" action="' .
                    route('moderator.ticket.blacklist.change', ['id' => $blacklist->id]) .
                    '">
            ' .
                    csrf_field() .
                    '
            ' .
                    method_field('POST') .
                    '
    <button data-content="' .
                    __('Change Status') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" class="flex items-center justify-between rounded-lg px-2 py-2 text-sm font-medium leading-5 text-purple-600 focus:outline outline-purple-600/50 dark:outline-gray-600/50 dark:text-gray-400" aria-label="Close">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>      </button>
      </form>
      <form class="d-inline"  method="post" action="' .
                    route('moderator.ticket.blacklist.delete', ['id' => $blacklist->id]) .
                    '">
          ' .
                    csrf_field() .
                    '
          ' .
                    method_field('POST') .
                    '
      <button data-content="' .
                    __('Delete') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" class="flex items-center justify-between rounded-lg px-2 py-2 text-sm font-medium leading-5 text-purple-600 focus:outline outline-purple-600/50 dark:outline-gray-600/50 dark:text-gray-400" aria-label="Delete">
      <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
      </svg>
      </button>
      </form>
  </div>
                ';
            })
            ->editColumn('created_at', function (TicketBlacklist $blacklist) {
                return $blacklist->created_at ? $blacklist->created_at->diffForHumans() : '';
            })
            ->rawColumns(['user', 'status', 'reason', 'created_at', 'actions'])
            ->make(true);
    }
}
