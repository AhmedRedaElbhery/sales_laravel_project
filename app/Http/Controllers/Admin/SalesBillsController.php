<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\ItemCard;
use App\Models\SalesBills;
use App\Models\SalesMaterialType;
use App\Models\Unit;
use Illuminate\Http\Request;

class SalesBillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = SalesBills::where(['com_code' => $com_code])->orderby('id', 'DESC')->paginate(11);

        if (!empty($data)) {
            foreach ($data as $item) {
                $item['sales_material_name'] = SalesMaterialType::where('id', $item['sales_material_type_id'])->value('name');
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                $item['customer_name'] = Customer::where(['account_number' => $item->account_number, 'com_code' => $com_code])->value('name');
                if ($item->updated_at && $item->updated_at  != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }

        $customers = Customer::select('id','name')->where(['active'=>1, 'com_code' => $com_code])->get();
        $items = ItemCard::select('item_code','name')->where([ 'com_code' => $com_code])->get();

        return view('admin.sales_bills.index', compact('data','customers','items'));
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

    public function getUnits(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $item_code = $request->item_code;

            $data = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code])->first();
            if ($data['has_retail_unit'] == 1) {
                $data['parent_unit_name'] = Unit::where(['id' => $data['parent_unit_id']])->value('name');
                $data['retail_unit_name'] = Unit::where(['id' => $data['retail_unit_id']])->value('name');
            } else {
                $data['parent_unit_name'] = Unit::where(['id' => $data['parent_unit_id']])->value('name');
            }
        }
        return view('admin.sales_bills.getUnits', compact('data'));
    }
}