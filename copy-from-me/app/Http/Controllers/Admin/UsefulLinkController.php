<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UsefulLinkLocation;
use App\Http\Controllers\Controller;
use App\Models\UsefulLink;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsefulLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('admin.usefullinks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $positions = UsefulLinkLocation::cases();
        return view('admin.usefullinks.create')->with('positions', $positions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string',
            'title' => 'required|string|max:60',
            'link' => 'required|url|string|max:191',
            'description' => 'required|string|max:2000',
        ]);


        UsefulLink::create([
            'icon' => $request->icon,
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'position' => implode(",", $request->position),
        ]);

        return redirect()->route('admin.usefullinks.index')->with('success', __('link has been created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  UsefulLink  $usefullink
     * @return Response
     */
    public function show(UsefulLink $usefullink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UsefulLink  $usefullink
     * @return Application|Factory|View
     */
    public function edit(UsefulLink $usefullink)
    {
        $positions = UsefulLinkLocation::cases();
        return view('admin.usefullinks.edit', [
            'link' => $usefullink,
            'positions' => $positions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  UsefulLink  $usefullink
     * @return RedirectResponse
     */
    public function update(Request $request, UsefulLink $usefullink)
    {
        $request->validate([
            'icon' => 'required|string',
            'title' => 'required|string|max:60',
            'link' => 'required|url|string|max:191',
            'description' => 'required|string|max:2000',
        ]);

        $usefullink->update([
            'icon' => $request->icon,
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'position' => implode(",", $request->position),
        ]);

        return redirect()->route('admin.usefullinks.index')->with('success', __('link has been updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UsefulLink  $usefullink
     * @return Response
     */
    public function destroy(UsefulLink $usefullink)
    {
        $usefullink->delete();

        return redirect()->back()->with('success', __('product has been removed!'));
    }

    public function dataTable()
    {
        $query = UsefulLink::query();

        return datatables($query)
            ->addColumn('actions', function (UsefulLink $link) {
                return '

                       <div class="flex items-center text-sm">
                       <a data-content="' .
                    __('Edit') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.usefullinks.edit', $link->id) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                          </a>

                          <form class="d-inline" onsubmit="return submitResult();" method="post" action="' .
                    route('admin.usefullinks.destroy', $link->id) .
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
            ->editColumn('created_at', function (UsefulLink $link) {
                return $link->created_at ? $link->created_at->diffForHumans() : '';
            })
            ->editColumn('icon', function (UsefulLink $link) {
                return "<iconify-icon icon='$link->icon' height='24' width='24'></iconify-icon>";
            })
            ->rawColumns(['actions', 'icon'])
            ->make();
    }
}
