<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\ItemCard;
use App\Models\Store;
use App\Models\Unit;
use Illuminate\Http\Request;

class ItemCardBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::select('id', 'name')->get();
        $data = ItemCard::orderby('id', 'DESC')->paginate(10);

        foreach ($data as $item) {

            $item['unit_name'] = Unit::where(['id' => $item->parent_unit_id])->value('name');

            $item['retail_unit_name'] = Unit::where(['id' => $item->retail_unit_id])->value('name');

        }

        return view('admin.itemcard_balance.index', compact('data', 'stores'));
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
        //
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
        //
    }

    public function filter(Request $request)
    {
        $com_code = auth()->user()->com_code;
        $id = $request->store_id;

        $stores = Store::select('id','name')->get();

        $data = Batch::select('item_code', 'unit_id','quantity','production_date','end_date')->where(['store_id'=>$id,'com_code'=>$com_code])->get();

        if($data->isEmpty())
        {
            return redirect()->back()->with('error','there is no data');
        }

        if($id === 'all')
        {
            return redirect()->route('itemCardBalance.index');
        }

        foreach($data as $item)
        {
            $item['name'] = ItemCard::where(['item_code'=> $item->item_code,'com_code'=>$com_code ])->value('name');
            $item['unit_name'] = Unit::where(['id'=> $item->unit_id,'com_code'=>$com_code ])->value('name');
        }

        return view('admin.itemCard_balance.index',compact('data','id','stores'));
    }

}