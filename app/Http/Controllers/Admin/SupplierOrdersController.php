<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveBillRequest;
use App\Http\Requests\SupplierOrderRequest;
use App\Models\Admin;
use App\Models\AdminShifts;
use App\Models\ItemCard;
use App\Models\Store;
use App\Models\SupplierOrders;
use App\Models\SupplierOrdersDetails;
use App\Models\Suppliers;
use App\Models\Treasuries;
use App\Models\TreasuriesTransaction;
use App\Models\Unit;
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
                $item['store_name'] = Store::where('id', $item['store_id'])->value('name');
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                $item['supplier_name'] = Suppliers::where(['supplier_code' => $item->supplier_code, 'com_code' => $com_code])->value('name');
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
        $stores = Store::select('name', 'id')->where(['com_code' => $com_code, 'active' => 1])->get();
        return view('admin.supplier_orders.create', compact('suppliers', 'stores'));
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
        $data['store_id'] = $request->store;
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
        $com_code = auth()->user()->com_code;
        $data = SupplierOrders::find($id);
        if (!empty($data)) {
            $details = SupplierOrdersDetails::where(['supplier_auto_serial' => $data['auto_serial'], 'com_code' => $data['com_code'], 'order_type' => $data['order_type']])->get();

            $data['supplier_name'] = Suppliers::where('account_number', $data['account_number'])->value('name');
            $data['store_name'] = Store::where('id', $data['store_id'])->value('name');

            $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');

            if ($data['updated_by'] != null && $data['updated_by'] > 0) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }

            if ($details) {

                foreach ($details as $unit) {

                    $unit['item_name'] = ItemCard::where(['item_code' => $unit->item_code])->value('name');
                    $unit['unit_name'] = Unit::where(['id' => $unit->unit_id])->value('name');

                    $unit['added_by_admin'] = Admin::where('id', $unit->added_by)->value('name');

                    if ($unit['updated_by'] != null && $unit['updated_by'] > 0) {
                        $unit['updated_by_admin'] = Admin::where('id', $unit->updated_by)->value('name');
                    }
                }
            }
            $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
            if ($shift != null) {
                $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
                $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
            }

            if ($data['is_approved'] != 1) {

                $items = ItemCard::select('name', 'item_code', 'item_type')->where(['com_code' => $com_code, 'active' => 1])->get();
                return view('admin.supplier_orders.details', compact('data', 'details', 'items', 'shift'));
            }



            return view('admin.supplier_orders.details', compact('data', 'details', 'shift'));
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
        $com_code = auth()->user()->com_code;
        $suppliers = Suppliers::select('name', 'supplier_code')->where(['com_code' => $com_code])->get();
        $stores = Store::select('name', 'id')->where(['com_code' => $com_code, 'active' => 1])->get();
        $data = SupplierOrders::find($id);
        return view('admin.supplier_orders.edit', compact('data', 'suppliers', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, SupplierOrderRequest $request)
    {
        $com_code = auth()->user()->com_code;

        $data = SupplierOrders::where(['id' => $id, 'com_code' => $com_code])->first();
        $account_number = Suppliers::where(['supplier_code' => $request->supplier_code, 'com_code' => $com_code])->value('account_number');

        $data->update([
            'supplier_code' => $request->supplier_code,
            'pill_type' => $request->pill_type,
            'doc_number' => $request->doc_number,
            'store_id' => $request->store,
            'account_number' => $account_number,
            'updated_by' => auth()->user()->id,
        ]);
        return redirect()->route('supplier_orders.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SupplierOrders::find($id);
        $items = SupplierOrdersDetails::where(['supplier_auto_serial' => $data->auto_serial, 'com_code' => $data->com_code, 'order_type' => 1])->get();
        foreach ($items as $item) {
            SupplierOrdersDetails::destroy($item->id);
        }
        SupplierOrders::destroy($id);
        return redirect()->route('supplier_orders.index');
    }

    public function destroy_details($id)
    {
        $data = SupplierOrdersDetails::select('total_price', 'supplier_auto_serial', 'order_type', 'com_code')->where(['id' => $id])->first();
        $flage = SupplierOrdersDetails::destroy($id);
        if ($flage) {

            $total = SupplierOrders::select('discount_value', 'tax_value', 'total_before_discount')->where(['auto_serial' => $data->supplier_auto_serial, 'order_type' => $data->order_type, 'com_code' => $data->com_code])->first();


            SupplierOrders::where(['auto_serial' => $data->supplier_auto_serial, 'order_type' => $data->order_type, 'com_code' => $data->com_code])->update([
                'total_before_discount' => ($total->total_before_discount - $data->total_price),
                'total_cost' => ($total->total_before_discount - $data->total_price) - $total->discount_value + $total->tax_value,
            ]);
        }

        return redirect()->back();
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
        return view('admin.supplier_orders.getUnits', compact('data'));
    }

    public function addunits(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $parent_data = SupplierOrders::select('is_approved', 'order_date', 'tax_value', 'discount_value')->where(['auto_serial' => $request->autoserialparent, 'com_code' => $com_code, 'order_type' => 1])->first();
            if ($parent_data->is_approved != 1) {
                $data['supplier_auto_serial'] = $request->autoserialparent;
                $data['order_type'] = 1;
                $data['item_code'] = $request->item_card;
                $data['delivered_quantity'] = $request->quantity;
                $data['unit_price'] = $request->price * 100;
                $data['total_price'] = $request->total_price * 100;
                $data['com_code'] = $com_code;
                $data['order_date'] = $parent_data->order_date;
                $data['isparentunit'] = $request->isparent;
                $data['unit_id'] = $request->unit;
                $data['item_card_type'] = $request->type;
                $data['added_by'] = auth()->user()->id;
                if ($request->type == 2) {
                    $data['production_date'] = $request->production_date;
                    $data['end_date'] = $request->end_date;
                }

                $flage = SupplierOrdersDetails::create($data);
                if ($flage) {

                    $total = SupplierOrdersDetails::where(['com_code' => $com_code, 'order_type' => 1, 'supplier_auto_serial' => $request->autoserialparent])->sum('total_price');
                    SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'order_type' => 1, 'com_code' => $com_code])->update([
                        'updated_by' => auth()->user()->id,
                        'total_before_discount' => $total,
                        'total_cost' => $total - $parent_data->discount_value + $parent_data->tax_value,
                    ]);

                    echo json_encode('done');
                }
            }
        }
    }

    public function edititem(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $isapproved = SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'com_code' => $com_code, 'order_type' => 1])->value('is_approved');

            if ($isapproved != 1) {

                $item_data = SupplierOrdersDetails::find($request->id);
                $item_card_data = ItemCard::select('has_retail_unit', 'retail_unit_id', 'parent_unit_id')->where(['item_code' => $item_data->item_code, 'com_code' => $com_code])->first();
                $item_cards = ItemCard::where(['active' => 1, 'com_code' => $com_code])->get();
                if ($item_card_data->has_retail_unit == 1) {
                    $item_card_data->parent_unit_name = Unit::where('id', $item_card_data->parent_unit_id)->value('name');
                    $item_card_data->retail_unit_name = Unit::where('id', $item_card_data->retail_unit_id)->value('name');
                } else {
                    $item_card_data->parent_unit_name = Unit::where('id', $item_card_data->parent_unit_id)->value('name');
                }
                return view('admin.supplier_orders.edititem', compact('isapproved', 'item_card_data', 'item_data', 'item_cards'));
            }
        }
    }


    public function update_item(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $parent_data = SupplierOrders::select('is_approved', 'order_date', 'tax_value', 'discount_value')->where(['auto_serial' => $request->autoserialparent, 'com_code' => $com_code, 'order_type' => 1])->first();
            if ($parent_data->is_approved != 1) {


                $flage = SupplierOrdersDetails::where('id', $request->id)->update([
                    'delivered_quantity' => $request->quantity,
                    'unit_price'         => $request->price * 100,
                    'total_price'        => $request->total_price * 100,
                    'isparentunit'       => $request->isparent,
                    'unit_id'            => $request->unit,
                    'production_date'    => $request->production_date,
                    'end_date'           => $request->end_date,
                ]);
                if ($flage) {

                    $total = SupplierOrdersDetails::where(['com_code' => $com_code, 'order_type' => 1, 'supplier_auto_serial' => $request->autoserialparent])->sum('total_price');
                    SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'order_type' => 1, 'com_code' => $com_code])->update([
                        'updated_by' => auth()->user()->id,
                        'total_before_discount' => $total,
                        'total_cost' => $total - $parent_data->discount_value + $parent_data->tax_value,
                    ]);

                    echo json_encode('done');
                }
            }
        }
    }


    public function model_approve(ApproveBillRequest $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $auto_serial = $request->autoserialparent;

            $tax_percent = $request->tax_percent;
            $tax_value = $request->tax_value;
            $discount_percent = $request->discount_percent;
            $discount_value = $request->discount_value;

            $what_paid = $request->what_paid;
            $what_remain = $request->what_remain;

            $total_value = $request->total_value;
            $treasuries_id = $request->treasuries_id;
            $treasuries_balance = $request->treasuries_balance;

            $data = SupplierOrders::where(['auto_serial' => $auto_serial, 'com_code' => $com_code])->first();
            if ($data->is_approved == 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'هذه الفاتورة معتمدة من قبل',
                    'redirect' => route('supplier_orders.show', $data->id),
                ]);
            }

            if($data->pill_type == 0)
            {
                if($what_paid < $total_value)
                {
                    return response()->json([
                        'status' => false,
                        'message' => ' الفاتوره كاش ولا يمكن ان يكون المبلغ المدفوع افل من الاجمالى',
                    ]);
                }
            }
            else{

                if($what_paid == $total_value)
                {
                    return response()->json([
                        'status' => false,
                        'message' => ' الفاتوره اجل ولا يمكن ان يكون المبلغ المدفوع كاملا',

                    ]);
                }
            }

            $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
            if ($shift != null) {
                $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
                $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');

                $treasuries_balance = $shift->treasuries_balance /-100;

                if($what_paid > $treasuries_balance)
                {
                    return response()->json([
                        'status' => false,
                        'message' => ' الرصيد المتاح لا يسمح بالدفع',
                        'redirect' => route('supplier_orders.show', $data->id),
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => ' لا يوجد شفت مفتوح',
                    'redirect' => route('supplier_orders.show', $data->id),
                ]);
            }

            $flage = $data->update([
                'is_approved'=> 1,
                'discount_percent'=> $discount_percent,
                'discount_value'=> $discount_value*100,
                'tax_percent'=> $tax_percent,
                'tax_value'=> $tax_value*100,
                'total_cost'=> $total_value*100,
                'what_paid'=> $what_paid*100,
                'what_remain'=> $what_remain*100,
                'updated_by'=> auth()->user()->id,
            ]);

            if($flage)
            {
                if($what_paid > 0)
                {
                    $treasuries = Treasuries::where(['id' => $shift->treasuries_id , 'com_code'=>$com_code])->first();
                    if($treasuries->last_isal_exchange == null)
                    {
                        $$treasuries->last_isal_exchange = 0;
                    }
                    TreasuriesTransaction::create([
                        'treasuries_id'=>$shift->treasuries_id,
                        'bill_code'=>$data->auto_serial,
                        'is_approved'=>1,
                        'shift_id'=>$shift->id,
                        'com_code'=>$com_code,
                        'money'=>$what_paid * (100),
                        'isal_number'=> $treasuries->last_isal_exchange+1,
                        'date'=>date('Y-m-d'),
                        'byan'=>'فاتوره مشتريات',
                        'move_type'=>1,
                        'account_number'=>$data->account_number,
                        'money_for_account'=>$what_paid*100,
                        'added_by'=>auth()->user()->id,
                    ]);

                    $treasuries->update([
                        'last_isal_exchange'=> $treasuries->last_isal_exchange+1,
                    ]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'تم اعتماد الفاتورة بنجاح',
            ]);

        }
    }
}