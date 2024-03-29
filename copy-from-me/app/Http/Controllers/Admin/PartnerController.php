<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerDiscount;
use App\Models\User;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        return view('admin.partners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.partners.create', [
            'partners' => PartnerDiscount::get(),
            'users' => User::orderBy('name')->get(),
        ]);
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
            'user_id' => 'required|integer|min:0',
            'partner_discount' => 'required|integer|max:100|min:0',
            'registered_user_discount' => 'required|integer|max:100|min:0',
        ]);

        if(PartnerDiscount::where("user_id",$request->user_id)->exists()){
            return redirect()->route('admin.partners.index')->with('error', __('Partner already exists'));
        }

        PartnerDiscount::create($request->all());

        return redirect()->route('admin.partners.index')->with('success', __('partner has been created!'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Partner  $partner
     * @return Application|Factory|View
     */
    public function edit(PartnerDiscount $partner)
    {
        return view('admin.partners.edit', [
            'partners' => PartnerDiscount::get(),
            'partner' => $partner,
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Partner  $partner
     * @return RedirectResponse
     */
    public function update(Request $request, PartnerDiscount $partner)
    {
        //dd($request);
        $request->validate([
            'user_id' => 'required|integer|min:0',
            'partner_discount' => 'required|integer|max:100|min:0',
            'registered_user_discount' => 'required|integer|max:100|min:0',
        ]);

        $partner->update($request->all());

        return redirect()->route('admin.partners.index')->with('success', __('partner has been updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Partner  $partner
     * @return RedirectResponse
     */
    public function destroy(PartnerDiscount $partner)
    {
        $partner->delete();

        return redirect()->back()->with('success', __('partner has been removed!'));
    }

    

    public function dataTable()
    {
        $query = PartnerDiscount::query();

        return datatables($query)
            ->addColumn('actions', function (PartnerDiscount $partner) {
                return '
                       <div class="flex items-center text-sm">
                       

                       <a data-content="' .
                    __('Edit') .
                    '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' .
                    route('admin.partners.edit', $partner->id) .
                    '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                          </a>
                          <form class="d-inline" onsubmit="return submitResult();" method="post" action="' .
                    route('admin.partners.destroy', $partner->id) .
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
            ->addColumn('user', function (PartnerDiscount $partner) {
                return ($user = User::where('id', $partner->user_id)->first()) ? '<a class="text-purple-600 underline" href="'.route('admin.users.show', $partner->user_id).'">'.$user->name.'</a>' : __('Unknown user');
            })
            ->editColumn('created_at', function (PartnerDiscount $partner) {
                return $partner->created_at ? $partner->created_at->diffForHumans() : '';
            })
            ->editColumn('partner_discount', function (PartnerDiscount $partner) {
                return $partner->partner_discount ? $partner->partner_discount.'%' : '0%';
            })
            ->editColumn('registered_user_discount', function (PartnerDiscount $partner) {
                return $partner->registered_user_discount ? $partner->registered_user_discount.'%' : '0%';
            })
            ->editColumn('referral_system_commission', function (PartnerDiscount $partner) {
                return $partner->referral_system_commission >= 0 ? $partner->referral_system_commission.'%' : __('Default').' ('.config('SETTINGS::REFERRAL:PERCENTAGE').'%)';
            })
            ->rawColumns(['user', 'actions'])
            ->make();
    }
}
