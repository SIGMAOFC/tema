<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationApi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('admin.api.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('admin.api.create');
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
            'memo' => 'nullable|string|max:60',
        ]);

        ApplicationApi::create([
            'memo' => $request->input('memo'),
        ]);

        return redirect()
            ->route('admin.api.index')
            ->with('success', __('api key created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param ApplicationApi $applicationApi
     * @return Response
     */
    public function show(ApplicationApi $applicationApi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ApplicationApi $applicationApi
     * @return Application|Factory|View|Response
     */
    public function edit(ApplicationApi $applicationApi)
    {
        return view('admin.api.edit', [
            'applicationApi' => $applicationApi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ApplicationApi $applicationApi
     * @return RedirectResponse
     */
    public function update(Request $request, ApplicationApi $applicationApi)
    {
        $request->validate([
            'memo' => 'nullable|string|max:60',
        ]);

        $applicationApi->update($request->all());

        return redirect()
            ->route('admin.api.index')
            ->with('success', __('api key updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ApplicationApi $applicationApi
     * @return RedirectResponse
     */
    public function destroy(ApplicationApi $applicationApi)
    {
        $applicationApi->delete();
        return redirect()
            ->back()
            ->with('success', __('api key has been removed!'));
    }

    /**
     * @param Request $request
     * @return JsonResponse|mixed
     * @throws Exception
     */
    public function dataTable(Request $request)
    {
        $query = ApplicationApi::query();

        return datatables($query)
            ->addColumn('actions', function (ApplicationApi $apiKey) {
                return '
                       <div class="flex items-center text-sm">

                       <a data-content="' .
                    __('Edit') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.api.edit', $apiKey->token) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                          </a>
                        
                          <form class="d-inline" onsubmit="return submitResult();" method="post" action="' .
                    route('admin.api.destroy', $apiKey->token) .
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
            ->editColumn('token', function (ApplicationApi $apiKey) {
                return "<code class='bg-purple-200 rounded p-1 text-sm text-purple-600 dark:bg-gray-600 dark:text-gray-200'>{$apiKey->token}</code>";
            })
            ->editColumn('last_used', function (ApplicationApi $apiKey) {
                return $apiKey->last_used ? $apiKey->last_used->diffForHumans() : '';
            })
            ->rawColumns(['actions', 'token'])
            ->make();
    }
}
