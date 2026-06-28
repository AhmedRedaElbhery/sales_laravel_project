<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierOrderRequest;
use App\Models\Admin;
use App\Models\ItemCard;
use App\Models\SupplierOrders;
use App\Models\SupplierOrdersDetails;
use App\Models\Suppliers;
use Illuminate\Http\Request;

class SupplierOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = SupplierOrders::where(['com_code' => $com_code])->orderby('id', 'DESC')->paginate(11);

        if (!empty($data)) {
            foreach ($data as $item) {
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                $item['supplier_name'] = Suppliers::select('name')->where(['supplier_code' => $item->supplier_code, 'com_code' => $com_code])->value('name');
                if ($item->updated_at && $item->updated_at  != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.supplier_orders.index', compact('data'));
    }


    public function create()
    {
        $com_code = auth()->user()->com_code;
        $suppliers = Suppliers::select('name', 'supplier_code')->where(['com_code' => $com_code])->get();

        return view('admin.supplier_orders.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierOrderRequest $request)
    {
        $com_code = auth()->user()->com_code;
        $serial = SupplierOrders::max('auto_serial');


        if ($serial == null) {
            $data['auto_serial'] = 1;
        } else {
            $data['auto_serial'] = $serial + 1;
        }

        $account_number = Suppliers::select('account_number')->where(['supplier_code' => $request->supplier_code, 'com_code' => $com_code])->value('account_number');

        $data['order_date'] = $request->order_date;
        $data['pill_type'] = $request->pill_type;
        $data['notes'] = $request->notes;
        $data['doc_number'] = $request->doc_number;
        $data['supplier_code'] = $request->supplier_code;

        $data['added_by'] = auth()->user()->id;
        $data['com_code'] = $com_code;
        $data['account_number'] = $account_number;
        $data['order_type'] = 1;

        SupplierOrders::create($data);
        return redirect()->route('supplier_orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $com_code = auth()->user()->id;
        $data = SupplierOrders::find($id);
        if (!empty($data)) {
            $details = SupplierOrdersDetails::where(['supplier_auto_serial' => $data['auto_serial'], 'com_code' => $data['com_code'], 'order_type' => $data['order_type']])->first();

            $data['supplier_name'] = Suppliers::where('account_number', $data['account_number'])->value('name');

            $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');

            if ($data['updated_by'] != null && $data['updated_by'] > 0) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }

            if ($details) {

                $details['item_name'] = ItemCard::where(['item_code' => $details->item_code])->value('name');


                $details['added_by_admin'] = Admin::where('id', $details['added_by'])->value('name');

                if ($details['updated_by'] != null && $details['updated_by'] > 0) {
                    $details['updated_by_admin'] = Admin::where('id', $details['updated_by'])->value('name');
                }
            }

            return view('admin.supplier_orders.details', compact('data', 'details'));
        }
        return redirect()->route('supplier_orders.index');
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