<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Nest;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.products.create', [
            'locations' => Location::with('nodes')->get(),
            'nests' => Nest::with('eggs')->get(),
        ]);
    }

    public function clone(Request $request, Product $product)
    {
        return view('admin.products.create', [
            'product' => $product,
            'locations' => Location::with('nodes')->get(),
            'nests' => Nest::with('eggs')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *

            ->editColumn('minimum_credits', function (Product $product) {
                return $product->minimum_credits==-1 ? config('SETTINGS::USER:MINIMUM_REQUIRED_CREDITS_TO_MAKE_SERVER') : $product->minimum_credits;
            })     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'price' => 'required|numeric|max:1000000|min:0',
            'memory' => 'required|numeric|max:1000000|min:5',
            'cpu' => 'required|numeric|max:1000000|min:0',
            'swap' => 'required|numeric|max:1000000|min:0',
            'description' => 'required|string|max:191',
            'disk' => 'required|numeric|max:1000000|min:5',
            'minimum_credits' => 'required|numeric|max:1000000|min:-1',
            'io' => 'required|numeric|max:1000000|min:0',
            'databases' => 'required|numeric|max:1000000|min:0',
            'backups' => 'required|numeric|max:1000000|min:0',
            'allocations' => 'required|numeric|max:1000000|min:0',
            'nodes.*' => 'required|exists:nodes,id',
            'eggs.*' => 'required|exists:eggs,id',
            'disabled' => 'nullable',
        ]);

        $disabled = !is_null($request->input('disabled'));
        $product = Product::create(array_merge($request->all(), ['disabled' => $disabled]));

        //link nodes and eggs
        $product->eggs()->attach($request->input('eggs'));
        $product->nodes()->attach($request->input('nodes'));

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('Product has been created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function show(Product $product)
    {
        return view('admin.products.show', [
            'product' => $product,
            'minimum_credits' => config('SETTINGS::USER:MINIMUM_REQUIRED_CREDITS_TO_MAKE_SERVER'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'locations' => Location::with('nodes')->get(),
            'nests' => Nest::with('eggs')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:30',
            'price' => 'required|numeric|max:1000000|min:0',
            'memory' => 'required|numeric|max:1000000|min:5',
            'cpu' => 'required|numeric|max:1000000|min:0',
            'swap' => 'required|numeric|max:1000000|min:0',
            'description' => 'required|string|max:191',
            'disk' => 'required|numeric|max:1000000|min:5',
            'io' => 'required|numeric|max:1000000|min:0',
            'minimum_credits' => 'required|numeric|max:1000000|min:-1',
            'databases' => 'required|numeric|max:1000000|min:0',
            'backups' => 'required|numeric|max:1000000|min:0',
            'allocations' => 'required|numeric|max:1000000|min:0',
            'nodes.*' => 'required|exists:nodes,id',
            'eggs.*' => 'required|exists:eggs,id',
            'disabled' => 'nullable',
        ]);

        $disabled = !is_null($request->input('disabled'));
        $product->update(array_merge($request->all(), ['disabled' => $disabled]));

        #link nodes and eggs
        $product->eggs()->detach();
        $product->nodes()->detach();
        $product->eggs()->attach($request->input('eggs'));
        $product->nodes()->attach($request->input('nodes'));

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('Product has been updated!'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function disable(Request $request, Product $product)
    {
        $product->update(['disabled' => !$product->disabled]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product)
    {
        $servers = $product->servers()->count();
        if ($servers > 0) {
            return redirect()
                ->back()
                ->with('error', "Product cannot be removed while it's linked to {$servers} servers");
        }

        $product->delete();
        return redirect()
            ->back()
            ->with('success', __('Product has been removed!'));
    }

    /**
     * @return JsonResponse|mixed
     * @throws Exception|Exception
     */
    public function dataTable()
    {
        $query = Product::with(['servers']);

        return datatables($query)
            ->addColumn('actions', function (Product $product) {
                return '

                <div class="flex items-center text-sm">
                       <a data-content="' .
                    __('Show') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.products.show', $product->id) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Login as User">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                       </a>

                       <a data-content="' .
                    __('Clone') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.products.clone', $product->id) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Verify">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                       </a>

                       <a data-content="' .
                    __('Edit') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.products.edit', $product->id) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                          </a>
                          <form class="d-inline" onsubmit="return submitResult();" method="post" action="' .
                    route('admin.products.destroy', $product->id) .
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

            ->addColumn('servers', function (Product $product) {
                return $product->servers()->count();
            })
            ->addColumn('nodes', function (Product $product) {
                return $product->nodes()->count();
            })
            ->addColumn('eggs', function (Product $product) {
                return $product->eggs()->count();
            })
            ->addColumn('disabled', function (Product $product) {
                $checked = $product->disabled == false ? 'checked' : '';
                
                return '
                    <form class="d-inline" onsubmit="return submitResult();" method="post" action="' .
                    route('admin.products.disable', $product->id) .
                    '">
                        ' .
                    csrf_field() .
                    '
                        ' .
                    method_field('PATCH') .
                    '
                        <input ' .
                    $checked .
                    ' name="disabled" onchange="this.form.submit()" type="checkbox" id="switch' .
                    $product->id .
                    '" class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded" />
                    </form>
                ';
            })
            ->editColumn('minimum_credits', function (Product $product) {
                return $product->minimum_credits==-1 ? config('SETTINGS::USER:MINIMUM_REQUIRED_CREDITS_TO_MAKE_SERVER') : $product->minimum_credits;
            })
            ->editColumn('created_at', function (Product $product) {
                return $product->created_at ? $product->created_at->diffForHumans() : '';
            })
            ->rawColumns(['actions', 'disabled'])
            ->make();
    }
}
