<?php

namespace App\Http\Controllers\BizTools;

use App\Models\BizTools\Board;
use App\Http\Controllers\Controller;
use App\Models\BizTools\SalesLeadsAndCustomer;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = Board::with(['leads' => function($query){
            return $query->orderBy('sort_order');
        }])->get();
        $leads = SalesLeadsAndCustomer::with('board')->leads()->get();
        $classes = ['error','info','warning','success'];

        return view('biz_tools.backend..leads.index',compact('boards','classes','leads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->action == null && $request->action != 'update') {
            
            $lead = SalesLeadsAndCustomer::create([
                'title' => $request->lead_title,
                'name' => $request->lead_firstname,
                'last_name' => $request->lead_lastname,
                'board_id' => $request->lead_status,
                'category' => $request->lead_categoryid,
                'telephone' => $request->lead_phone,
                'email' => $request->lead_email,
                'source' => $request->lead_source,
                'notes' => json_encode($request->lead_description),
                'class' => 'hello',
                'last_contacted' => $request->lead_last_contacted,
            ]);
    
            if ($lead) {
                return back()->with('success','New Lead Added Successfully');
            }
        }
        else {
            $lead = SalesLeadsAndCustomer::findOrFail($request->leadID);

            $lead->title = $request->lead_title;
            $lead->name = $request->lead_firstname;
            $lead->last_name = $request->lead_lastname;
            $lead->board_id = $request->lead_status;
            $lead->category = $request->lead_categoryid;
            $lead->telephone = $request->lead_phone;
            $lead->email = $request->lead_email;
            $lead->source = $request->lead_source;
            $lead->notes = json_encode($request->lead_description);
            $lead->class = 'hello';
            $lead->last_contacted = $request->lead_last_contacted;

            if ($lead->update()) {

                return back()->with('success','Lead Updated Successfully');

            }
            return back()->with('error','Something Went Wrong !!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lead = SalesLeadsAndCustomer::find($id);

        if ($lead->delete()) {
            if (request()->expectsJson()) {    
                return response()->json(['status' => true]);
            }
            else {
                return back()->with('success','Lead Deleted Successfully');
            }
        }
        else {
            if (request()->expectsJson()) {    
                return response()->json(['status' => false]);
            }
            else {
                return back()->with('error','Something Went Wrong');
            }
        }
    }

    /**
     * Update Lead Board When Dragged
     * 
     */
    public function updateBoard(Request $request)
    {
        $lead = SalesLeadsAndCustomer::leads()->where('id',$request->lead_id)->first();

        $lead->board_id = $request->new_board;
        $lead->sort_order = $request->sort;

        if($lead->update())
        {
            return response()->json(['status' => true]);
        }
        else
        {
            return response()->json(['status' => false]);
        }
    }

    /**
     * Fetch Lead Details
     * 
     */
    public function fetchLeadDetails($id)
    {
        $lead = SalesLeadsAndCustomer::with('board')->leads()->find($id);

        if ($lead) {
            return response()->json(['status' => true , 'data' => $lead]);
        }
        else {
            return response()->json(['status' => false , 'data' => []]);
        }
    }

    /**
     * Convert Lead To Customer
     * 
     * 
     */
    public function convertToCustomer($leadID)
    {
        $lead = SalesLeadsAndCustomer::with('board')->leads()->where('id',$leadID)->firstOrFail();

        $lead->is_customer = true;

        if ($lead->update()) {
            return back()->with('success','Lead Moved To Customer Successfully');
        }
    }
}
