<?php

namespace App\Http\Controllers\BizTools;

use App\Models\BizTools\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = Subscription::sum('monthly_cost'); 
        return view('biz_tools.backend..subscriptions.index',compact('total'));
    }

    /**
     * Send Data to datatables
     *
     */
    public function fetchData(Request $request)
    {
        $columns = [
            0 => 'name',
            1 => 'website_link',
            2 => 'monthly_cost',
            3 => 'created_at',
        ];

        $totalData = Subscription::count();
        

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')) && empty($request->input('searchName')) && empty($request->input('searchCost'))) {
            $subscriptions = Subscription::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $searchName = $request->input('searchName') ?? '';
            $websiteLink = $request->input('websiteLink') ?? '';

            $subscriptions = Subscription::where('name', 'LIKE', "%{$searchName}%")
            ->where('website_link', 'LIKE', "%{$websiteLink}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

            $totalFiltered = Subscription::where('name', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$searchName}%")
            ->orWhere('website_link', '=', "{$websiteLink}")
            ->count();
        }

        $data = [];
        if (!empty($subscriptions)) {
            foreach ($subscriptions as $post) {

                $link = Str::startsWith($post->website_link, ['http://','https://']) ?  $post->website_link : 'https://'.$post->website_link;
                $nestedData['name'] = $post->name;
                $nestedData['website_link'] = "<a href='" .$link. "' title='Link' target='_blank'>Open</a>";
                $nestedData['monthly_cost'] = $post->monthly_cost;
                $nestedData['action'] = "&emsp;<a href='javascript:;' title='destroy' class='btn btn-danger deleteItem' data-method='DELETE' data-id='{$post->id}'>Delete</a>
                          &emsp;<a href='javascript:;' title='EDIT' class='btn btn-info editItem'  data-id='{$post->id}'>Edit</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data'            => $data,
        ];

        echo json_encode($json_data);
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
        $subscription = Subscription::create([
            'name'         => $request->name,
            'website_link' => $request->website_link,
            'monthly_cost' => $request->monthly_cost,
        ]);

        if ($subscription) {
            return back()->with('success', 'Subscription add successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        return response()->json(['status' => true,'data' => $subscription]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $subscription->name = $request->name;
        $subscription->website_link = $request->website_link;
        $subscription->monthly_cost = $request->monthly_cost;

        if ($subscription->update()) {
            return back()->with('success', 'Subscription updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        if ($subscription->delete()) {
            return back()->with('success', 'Subscription deleted successfully');
        }
    }
}
