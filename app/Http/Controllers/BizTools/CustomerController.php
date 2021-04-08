<?php

namespace App\Http\Controllers\BizTools;

use App\Models\BizTools\Board;
use Illuminate\Http\Request;
use App\Models\BizTools\SalesLeadsAndCustomer;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = SalesLeadsAndCustomer::customers()->latest()->get();
        return view('biz_tools.backend..customers.index', compact('customers'));
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
        $user = SalesLeadsAndCustomer::create([
            'is_customer' => true,
            'name'        => $request->name,
            'last_name'   => $request->last_name,
            'email'       => $request->email,
            'telephone'   => $request->phone,
            'position'    => $request->position,
        ]);

        if ($user) {
            return back()->with('success', 'New Customer Added Successfully');
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
    public function update(Request $request, $user)
    {
        $user = SalesLeadsAndCustomer::findOrFail($user);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->phone;
        $user->position = $request->position;

        if ($user->update()) {
            return back()->with('success', 'Customer Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Convert Customer to lead
     *
     */
    public function convertToLead($id)
    {
        $user = SalesLeadsAndCustomer::customers()->where('id', $id)->firstOrFail();

        if ($user->title == '') {
            $user->title = $user->name . ' ' . $user->last_name;
        }

        if ($user->board_id == '') {
            $user->board_id = optional(Board::select('id')->inRandomOrder()->first())->id;
        }

        if ($user->category == '') {
            $user->category = 'default';
        }

        if ($user->source == '') {
            $user->source = 'yellow_pages';
        }

        if ($user->last_contacted == '') {
            $user->last_contacted = now();
        }

        $user->class = 'success';
        $user->is_customer = false;

        if ($user->update()) {
            return back()->with('success', 'Customer Moved To Leads Successfully');
        } else {
            return back()->with('success', 'Whoops Something Went Wrong');
        }
    }
}
