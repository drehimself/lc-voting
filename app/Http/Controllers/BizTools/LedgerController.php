<?php

namespace App\Http\Controllers\BizTools;

use App\Models\BizTools\Ledger;
use App\Models\BizTools\LedgerCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddLedgerRequest;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ledger = (new Ledger)->newQuery();

		if ($request->from != '')
		{

			$ledger->whereDate('date', '>', $request->from);
		}

		if ($request->to != '')
		{

			$ledger->whereDate('date', '<=', $request->to);
		}

        $ledgers = $ledger->with('ledgerCategory')->orderBy('date','asc')->get();
        $categories = LedgerCategory::orderBy('name','asc')->get();
        $totals = [
            'income' => $ledgers->where('type','income')->sum('amount'),
            'expense' => $ledgers->where('type','expense')->sum('amount'),
            'adjustment' => $ledgers->where('type','adjustment')->sum('amount'),
            'all' => $ledgers->sum('amount')
        ];

        return view('biz_tools.backend..ledgers.index', [
            'ledgers' => $ledgers,
            'categories' => $categories,
            'totals' => $totals
        ]);
    }

    /**
     * Create Ledger Cateogry
     *
     */
    public function createCategory(Request $request)
    {
        $category = LedgerCategory::forceCreate([
            'name' => $request->name,
        ]);

        if ($category) {
            return back()->with('success', 'Cateogry Added Successfully');
        }
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
    public function store(AddLedgerRequest $request)
    {
        $message = $request->type . ' created successfully';

        if ($request->id > 0) {
            $message = $request->type . ' updated successfully';
        }
        
        $data = $request->only('amount', 'ledger_category_id', 'description', 'date', 'type');
        $data['is_taxable'] = false;

        if ($request->type == 'expense') {
            $data['amount'] = '-' . $request->amount;
        }
        
        if ($request->has('is_taxable')) {
            $data['is_taxable'] = true;
        }

        Ledger::updateOrCreate(['id'=>$request->id], $data);
        return back()->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ledger = Ledger::findOrFail($id);

        if ($ledger->type == 'expense') {
            $ledger->amount = abs($ledger->amount);
        }
        
        if ($ledger) {
            return response()->json(['status' => true, 'data' => $ledger]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        Ledger::where('id', $id)->delete();
        return back()->with('success', 'Ledger Deleted Successfully');
    }
}
