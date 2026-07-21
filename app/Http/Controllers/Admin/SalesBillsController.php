<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminShifts;
use App\Models\Batche;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\ItemCard;
use App\Models\SalesBills;
use App\Models\SalesBillsDetails;
use App\Models\SalesMaterialType;
use App\Models\Store;
use App\Models\Treasuries;
use App\Models\TreasuriesTransaction;
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
                $item['customer_name'] = Customer::where(['customer_code' => $item->customer_code, 'com_code' => $com_code])->value('name');
                if ($item->updated_at && $item->updated_at  != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }

        $customers = Customer::select('customer_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $delegates = Delegate::select('delegate_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $items = ItemCard::select('item_code', 'name', 'item_type')->where(['com_code' => $com_code])->get();
        $stores = Store::select('id', 'name')->where(['com_code' => $com_code])->get();
        $sales_material_types = SalesMaterialType::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();

        $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
        if ($shift != null) {
            $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
            $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
        }

        return view('admin.sales_bills.index', compact('data', 'customers', 'items', 'stores', 'shift', 'delegates', 'sales_material_types'));
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

    public function get_batches(Request $request)
    {
        if ($request->ajax()) {

            $com_code = auth()->user()->com_code;
            $item_code = $request->item_code;
            $item_type = $request->item_type;
            $unit_id = $request->unit_id;
            $store_id = $request->store_id;


            if ($item_type == 2) {
                $batches_data = Batche::where(['item_code' => $item_code, 'unit_id' => $unit_id, 'store_id' => $store_id])->orderby('production_date', 'ASC')->get();
                return view('admin.sales_bills.getBatches', compact('batches_data'));
            } else {
                $total_quantity = Batche::where(['item_code' => $item_code, 'unit_id' => $unit_id, 'store_id' => $store_id])->sum('quantity');
                $batche_id = Batche::select('id')->where(['item_code' => $item_code, 'unit_id' => $unit_id, 'store_id' => $store_id])->get();
                return view('admin.sales_bills.getBatches', compact('total_quantity', 'batche_id'));
            }
        }
    }

    public function get_price(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $item_code = $request->item_code; // الصنف
            $type = $request->type; // جمله او نص جمله او قطاعى
            $parent_or_retail_unit = $request->unit_type; // وحده القياس الاساسيه او فرعيه
            $unit_id = $request->unit_id; // وحده القياس الاساسيه او فرعيه

            if ($parent_or_retail_unit == 1) {
                if ($type === "0") {
                    $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'parent_unit_id' => $unit_id])->value('Wholesale_price');
                }
                if ($type == 1) {
                    $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'parent_unit_id' => $unit_id])->value('half_Wholesale_price');
                }
                if ($type == 2) {
                    $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'parent_unit_id' => $unit_id])->value('price');
                }
            } else {
                if ($type === "0") {
                    $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'retail_unit_id' => $unit_id])->value('retail_Wholesale_price');
                }
                if ($type == 1) {
                    $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'retail_unit_id' => $unit_id])->value('retail_half_Wholesale_price');
                }
                if ($type == 2) {
                    $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'retail_unit_id' => $unit_id])->value('retail_price');
                }
            }
        }
        return response()->json([
            'price' => $price / 100,
        ]);
    }

    public function get_add_items(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;

            $data['normal_sale'] = $request->normal_sale;
            $data['store_id'] = $request->store_id;
            $data['item_code'] = $request->item_code;
            $data['parent_unit'] = $request->parent_unit;
            $data['unit_id'] = $request->unit_id;
            $data['batche_id'] = $request->quantity_with_date;
            $data['sale_type'] = $request->sale_type;
            $data['quantity'] = $request->quantity;
            $data['price'] = $request->price;
            $data['total_price'] = $request->total_price;


            $data['unit_name'] = $request->unit_name;
            $data['item_name'] = $request->item_name;
            $data['normal_sale_name'] = $request->normal_sale_name;
            $data['sale_type_name'] = $request->sale_type_name;


            return view('admin.sales_bills.get_add_items', compact('data'));
        }
    }

    public function open_active_bill(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $customer_code = $request->customer_code;
            $delegate_code = $request->delegate_code;
            $date = $request->date;
            $sales_material_type_id = $request->sales_material_type_id;

            $serial = SalesBills::max('auto_serial');
            if ($serial == null) {
                $data['auto_serial'] = 1;
            } else {
                $data['auto_serial'] = $serial + 1;
            }

            $data['customer_code'] = $customer_code;
            $data['delegate_code'] = $delegate_code;

            $data['added_by'] = auth()->user()->id;
            $data['com_code'] = $com_code;
            $data['invoice_date'] = $date;
            $data['sales_material_type_id'] = $sales_material_type_id;

            $data = SalesBills::create($data);

            if ($data) {

                $customers = Customer::select('customer_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
                $delegates = Delegate::select('delegate_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
                $items = ItemCard::select('item_code', 'name', 'item_type')->where(['com_code' => $com_code])->get();
                $stores = Store::select('id', 'name')->where(['com_code' => $com_code])->get();
                $sales_material_types = SalesMaterialType::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();
                $bill_details = SalesBillsDetails::where(['com_code' => $com_code, 'bill_auto_serial' => $data['auto_serial']])->get();

                $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
                if ($shift != null) {
                    $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
                    $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
                }

                return view('admin.sales_bills.active_model_items', compact('data', 'customers', 'delegates', 'items', 'stores', 'sales_material_types', 'shift', 'bill_details'));
            }
        }
    }

    public function get_active_bill_data(Request $request)
    {
        $auto_serial = $request->auto_serial;
        $com_code = auth()->user()->com_code;

        $data = SalesBills::where(['com_code' => $com_code, 'auto_serial' => $auto_serial])->first();

        $customers = Customer::select('customer_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $delegates = Delegate::select('delegate_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $items = ItemCard::select('item_code', 'name', 'item_type')->where(['com_code' => $com_code])->get();
        $stores = Store::select('id', 'name')->where(['com_code' => $com_code])->get();
        $sales_material_types = SalesMaterialType::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();
        $bill_details = SalesBillsDetails::where(['com_code' => $com_code, 'bill_auto_serial' => $auto_serial])->get();

        $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
        if ($shift != null) {
            $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
            $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
        }

        return view('admin.sales_bills.active_model_items', compact('data', 'customers', 'delegates', 'items', 'stores', 'sales_material_types', 'shift', 'bill_details'));
    }

    public function active_add_items(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;

            $data['customer_code'] = $request->customer_code;
            $data['delegate_code'] = $request->delegate_code;
            $data['invoice_date'] = $request->invoice_date;
            $data['sales_material_type'] = $request->sales_material_type;
            $data['normal_sale'] = $request->normal_sale;
            $data['store_id'] = $request->store_id;
            $data['item_code'] = $request->item_code;
            $data['parent_unit'] = $request->parent_unit;
            $data['unit_id'] = $request->unit_id;
            $data['batche_id'] = $request->quantity_with_date;
            $data['sale_type'] = $request->sale_type;
            $data['quantity'] = $request->quantity;
            $data['price'] = $request->price;
            $data['total_price'] = $request->total_price;


            $data['unit_name'] = $request->unit_name;
            $data['item_name'] = $request->item_name;
            $data['normal_sale_name'] = $request->normal_sale_name;
            $data['sale_type_name'] = $request->sale_type_name;


            return view('admin.sales_bills.get_add_items', compact('data'));
        }
    }
}