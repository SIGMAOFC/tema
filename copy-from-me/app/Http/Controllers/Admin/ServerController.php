<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Pterodactyl;
use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('admin.servers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Server  $server
     * @return Response
     */
    public function edit(Server $server)
    {
        // get all users from the database
        $users = User::all();

        return view('admin.servers.edit')->with([
            'server' => $server,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Server  $server
     */
    public function update(Request $request, Server $server)
    {
        $request->validate([
            'identifier' => 'required|string',
            'user_id' => 'required|integer',
        ]);


        if ($request->get('user_id') != $server->user_id) {
            // find the user
            $user = User::findOrFail($request->get('user_id'));

            // try to update the owner on pterodactyl
            try {
                $response = Pterodactyl::updateServerOwner($server, $user->pterodactyl_id);
                if ($response->getStatusCode() != 200) {
                    return redirect()->back()->with('error', 'Failed to update server owner on pterodactyl');
                }

                // update the owner on the database
                $server->user_id = $user->id;
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Internal Server Error');
            }
        }

        // update the identifier
        $server->identifier = $request->get('identifier');
        $server->save();

        return redirect()->route('admin.servers.index')->with('success', 'Server updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Server  $server
     * @return RedirectResponse|Response
     */
    public function destroy(Server $server)
    {
        try {
            $server->delete();

            return redirect()->route('admin.servers.index')->with('success', __('Server removed'));
        } catch (Exception $e) {
            return redirect()->route('admin.servers.index')->with('error', __('An exception has occurred while trying to remove a resource "') . $e->getMessage() . '"');
        }
    }

    /**
     * @param  Server  $server
     * @return RedirectResponse
     */
    public function toggleSuspended(Server $server)
    {
        try {
            $server->isSuspended() ? $server->unSuspend() : $server->suspend();
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('success', __('Server has been updated!'));
    }

    public function syncServers()
    {
        $pteroServers = Pterodactyl::getServers();
        $CPServers = Server::get();

        $CPIDArray = [];
        $renameCount = 0;
        foreach ($CPServers as $CPServer) { //go thru all CP servers and make array with IDs as keys. All values are false.
            if ($CPServer->pterodactyl_id) {
                $CPIDArray[$CPServer->pterodactyl_id] = false;
            }
        }

        foreach ($pteroServers as $server) { //go thru all ptero servers, if server exists, change value to true in array.
            if (isset($CPIDArray[$server['attributes']['id']])) {
                $CPIDArray[$server['attributes']['id']] = true;

                if (isset($server['attributes']['name'])) { //failsafe
                    //Check if a server got renamed
                    $savedServer = Server::query()->where('pterodactyl_id', $server['attributes']['id'])->first();
                    if ($savedServer->name != $server['attributes']['name']) {
                        $savedServer->name = $server['attributes']['name'];
                        $savedServer->save();
                        $renameCount++;
                    }
                }
            }
        }
        $filteredArray = array_filter($CPIDArray, function ($v, $k) {
            return $v == false;
        }, ARRAY_FILTER_USE_BOTH); //Array of servers, that dont exist on ptero (value == false)
        $deleteCount = 0;
        foreach ($filteredArray as $key => $CPID) { //delete servers that dont exist on ptero anymore
            if (!Pterodactyl::getServerAttributes($key, true)) {
                $deleteCount++;
            }
        }

        return redirect()->back()->with('success', __('Servers synced successfully' . (($renameCount) ? (',\n' . __('renamed') . ' ' . $renameCount . ' ' . __('servers')) : '') . ((count($filteredArray)) ? (',\n' . __('deleted') . ' ' . $deleteCount . '/' . count($filteredArray) . ' ' . __('old servers')) : ''))) . '.';
    }

    /**
     * @return JsonResponse|mixed
     * 
     * @throws Exception
     */
    public function dataTable(Request $request)
    {
        $query = Server::with(['user', 'product']);


        if ($request->has('product')) {
            $query->where('product_id', '=', $request->input('product'));
        }
        if ($request->has('user')) {
            $query->where('user_id', '=', $request->input('user'));
        }
        $query->select('servers.*');

        Log::info($request->input('order'));


        return datatables($query)
            ->addColumn('user', function (Server $server) {
                return '<a data-content="' . __("Show") . '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' . route('admin.users.show', $server->user->id) . '">' . $server->user->name . '</a>';
            })
            ->addColumn('resources', function (Server $server) {
                return $server->product->description;
            })
            ->addColumn('actions', function (Server $server) {
                $suspendColor = $server->isSuspended() ? "btn-success" : "btn-warning";
                $suspendIcon = $server->isSuspended() ? "fa-play-circle" : "fa-pause-circle";
                $suspendText = $server->isSuspended() ? __("Unsuspend") : __("Suspend");

                return '
                       <div class="flex items-center text-sm">
                       

                       <a data-content="' . __("Edit") . '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' . route('admin.servers.edit', $server->id) . '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                          </a>
                        <form class="d-inline" method="post" action="' . route('admin.servers.togglesuspend', $server->id) . '">
                          ' . csrf_field() . '
                       <button data-content="' . __($suspendText) . '" data-toggle="popover" data-trigger="hover" data-placement="top" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-yellow-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Suspend">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                          </button>
                          </form>
                          <form class="d-inline" onsubmit="return submitResult();" method="post" action="' . route('admin.servers.destroy', $server->id) . '">
                          ' . csrf_field() . '
                          ' . method_field("DELETE") . '
                       <button data-content="' . __("Delete") . '" data-toggle="popover" data-trigger="hover" data-placement="top" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                          </button>
                          </form>
                          </div>

                ';
            })
            ->addColumn('status', function (Server $server) {
                $labelColor = $server->isSuspended() ? 'text-yellow-700 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-500' : 'text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500';
                $labelText = $server->isSuspended() ? __("Suspended") : __("Active");
                return '<span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full ' . $labelColor . '">' . $labelText . '</span>';
            })
            ->editColumn('created_at', function (Server $server) {
                return $server->created_at ? $server->created_at->diffForHumans() : '';
            })
            ->editColumn('suspended', function (Server $server) {
                return $server->suspended ? $server->suspended->diffForHumans() : '';
            })
            ->editColumn('name', function (Server $server) {
                return '<a class="font-medium text-purple-600 dark:text-purple-500 hover:underline" target="_blank" href="' . config("SETTINGS::SYSTEM:PTERODACTYL:URL") . '/admin/servers/view/' . $server->pterodactyl_id . '">' . strip_tags($server->name) . '</a>';
            })
            ->rawColumns(['user', 'actions', 'status', 'name'])
            ->make();
    }
}
