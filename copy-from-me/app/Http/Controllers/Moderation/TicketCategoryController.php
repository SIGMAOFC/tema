<?php

namespace App\Http\Controllers\Moderation;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = TicketCategory::all();
        return view('moderator.ticket.category')->with("categories",$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        TicketCategory::create($request->all());


        return redirect(route("moderator.ticket.category.index"))->with("success",__("Category created"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'category' => 'required|int',
            'name' => 'required|string|max:191',
        ]);

        $category = TicketCategory::where("id",$request->category)->firstOrFail();

        $category->name = $request->name;
        $category->save();

        return redirect()->back()->with("success",__("Category name updated"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = TicketCategory::where("id",$id)->firstOrFail();

        if($category->id == 5 ){ //cannot delete "other" category
            return back()->with("error","You cannot delete that category");
        }

        $tickets = Ticket::where("ticketcategory_id",$category->id)->get();

        foreach($tickets as $ticket){
            $ticket->ticketcategory_id = "5";
            $ticket->save();
        }

        $category->delete();

        return redirect()
            ->route('moderator.ticket.category.index')
            ->with('success', __('Category removed'));
    }

    public function datatable()
    {
        $query = TicketCategory::withCount("tickets");

        return datatables($query)
            ->addColumn('name', function ( TicketCategory $category) {
                return $category->name;
            })
            ->editColumn('tickets', function ( TicketCategory $category) {
                return $category->tickets_count;
            })
            ->addColumn('actions', function (TicketCategory $category) {
                return '


                <div class="flex items-center text-sm">

                 
                   <form class="d-inline" onsubmit="return submitResult();" method="post" action="' .
             route('moderator.ticket.category.destroy', $category->id) .
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
            ->editColumn('created_at', function (TicketCategory $category) {
                return $category->created_at ? $category->created_at->diffForHumans() : '';
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
