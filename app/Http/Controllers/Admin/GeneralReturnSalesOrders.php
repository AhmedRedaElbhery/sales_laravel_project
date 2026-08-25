<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminShifts;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\GeneralReturnSalesOrder;
use App\Models\ItemCard;
use App\Models\SalesMaterialType;
use App\Models\Store;
use App\Models\Treasuries;
use App\Models\TreasuriesTransaction;
use Illuminate\Http\Request;

class GeneralReturnSalesOrders extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = GeneralReturnSalesOrder::where(['com_code' => $com_code])->orderby('id', 'DESC')->paginate(11);

        foreach ($data as $item) {
            $item['sales_material_name'] = SalesMaterialType::where('id', $item['sales_material_type_id'])->value('name');
            $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
            $item['customer_name'] = Customer::where(['customer_code' => $item->customer_code, 'com_code' => $com_code])->value('name');
            if ($item->updated_at && $item->updated_at  != null) {
                $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
            }
        }

        $stores = Store::select('id', 'name')->where(['com_code' => $com_code])->get();

        $customers = Customer::select('customer_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $delegates = Delegate::select('delegate_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $items = ItemCard::select('item_code', 'name', 'item_type')->where(['com_code' => $com_code])->get();
        $sales_material_types = SalesMaterialType::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();

        $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
        if ($shift != null) {
            $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
            $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
        }

        return view('admin.general_return_sales_orders.index', compact('data', 'customers', 'items', 'stores', 'shift', 'delegates', 'sales_material_types'));
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
}