<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminShifts;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\GeneralReturnSalesOrder;
use App\Models\GeneralReturnSalesOrdersDetails;
use App\Models\ItemCard;
use App\Models\SalesMaterialType;
use App\Models\Store;
use App\Models\Treasuries;
use App\Models\TreasuriesTransaction;
use App\Models\Unit;
use Illuminate\Http\Request;

use App\Enums;
use App\Enums\SalesType;
use App\Models\Batch;
use App\Models\ItemMovement;

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


    public function open_active_bill(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $com_code = auth()->user()->com_code;
        $customer_code = $request->customer_code;
        $delegate_code = $request->delegate_code;
        $date = $request->date;
        $sales_material_type_id = $request->sales_material_type_id;

        $serial = GeneralReturnSalesOrder::max('auto_serial');

        $data = [
            'auto_serial' => $serial == null ? 0 : $serial + 1,
            'customer_code' => $customer_code,
            'delegate_code' => $delegate_code,
            'added_by' => auth()->user()->id,
            'com_code' => $com_code,
            'invoice_date' => $date,
            'sales_material_type_id' => $sales_material_type_id,
        ];

        $data = GeneralReturnSalesOrder::create($data);

        $customers = Customer::select('customer_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $delegates = Delegate::select('delegate_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $items = ItemCard::select('item_code', 'name', 'item_type')->where(['com_code' => $com_code])->get();
        $stores = Store::select('id', 'name')->where(['com_code' => $com_code])->get();
        $sales_material_types = SalesMaterialType::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();
        $bill_details = GeneralReturnSalesOrdersDetails::where(['com_code' => $com_code, 'bill_auto_serial' => $data->auto_serial])->get();
        $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
        if ($shift != null) {
            $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
        }

        $total_bill_cost = 0;
        $is_approved = $data->is_approved;

        return view('admin.general_return_sales_orders.active_model_items', compact('data', 'customers', 'delegates', 'items', 'stores', 'sales_material_types', 'shift', 'bill_details', 'total_bill_cost', 'is_approved'));
    }

    public function getUnits(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $com_code = auth()->user()->com_code;
        $item_code = $request->item_code;

        $data = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code])->first();
        $data['parent_unit_name'] = Unit::where(['id' => $data['parent_unit_id']])->value('name');

        if ($data['has_retail_unit'] == 1) {
            $data['retail_unit_name'] = Unit::where(['id' => $data['retail_unit_id']])->value('name');
        }
        return view('admin.general_return_sales_orders.getUnits', compact('data'));
    }

    public function get_price(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $com_code = auth()->user()->com_code;
        $item_code = $request->item_code; // الصنف
        $type = $request->type; // جمله او نص جمله او قطاعى
        $parent_or_retail_unit = $request->unit_type; // وحده القياس الاساسيه او فرعيه
        $unit_id = $request->unit_id; // وحده القياس الاساسيه او فرعيه


        if ($parent_or_retail_unit == 1) {
            if ($type == SalesType::WholePrice->value) {
                $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'parent_unit_id' => $unit_id])->value('Wholesale_price');
            }
            if ($type == SalesType::HafeWholePrice->value) {
                $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'parent_unit_id' => $unit_id])->value('half_Wholesale_price');
            }
            if ($type == SalesType::RetailPrice->value) {
                $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'parent_unit_id' => $unit_id])->value('price');
            }
        } else {
            if ($type == SalesType::WholePrice->value) {
                $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'retail_unit_id' => $unit_id])->value('retail_Wholesale_price');
            }
            if ($type == SalesType::HafeWholePrice->value) {
                $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'retail_unit_id' => $unit_id])->value('retail_half_Wholesale_price');
            }
            if ($type == SalesType::RetailPrice->value) {
                $price = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code, 'retail_unit_id' => $unit_id])->value('retail_price');
            }
        }

        return response()->json([
            'price' => $price / 100,
        ]);
    }


    public function get_active_bill_data(Request $request)
    {

        $auto_serial = $request->auto_serial;
        $com_code = auth()->user()->com_code;

        $data = GeneralReturnSalesOrder::where(['com_code' => $com_code, 'auto_serial' => $auto_serial])->first();
        $is_approved = $data->is_approved;

        $customers = Customer::select('customer_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $delegates = Delegate::select('delegate_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $items = ItemCard::select('item_code', 'name', 'item_type')->where(['com_code' => $com_code])->get();
        $stores = Store::select('id', 'name')->where(['com_code' => $com_code])->get();
        $sales_material_types = SalesMaterialType::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();
        $bill_details = GeneralReturnSalesOrdersDetails::where(['com_code' => $com_code, 'bill_auto_serial' => $auto_serial])->get();

        if ($bill_details != null) {

            $total_bill_cost = 0;
            foreach ($bill_details as $item) {
                $item['item_name'] = ItemCard::select()->where(['item_code' => $item->item_code, 'com_code' => $com_code])->value('name');
                $item['unit_name'] = Unit::where(['id' => $item->unit_id, 'com_code' => $com_code])->value('name');
                if ($item->normal_sale === "0") {
                    $item['sale_type_name'] = 'جمله';
                } else if ($item->normal_sale == 1) {
                    $item['sale_type_name'] = 'نص جمله';
                } else {
                    $item['sale_type_name'] = 'قطاعى';
                }

                $total_bill_cost = $item->total_price + $total_bill_cost;
            }
        }

        $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
        if ($shift != null) {
            $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
        }


        return view('admin.general_return_sales_orders.active_model_items', compact('data', 'customers', 'delegates', 'items', 'stores', 'sales_material_types', 'shift', 'bill_details', 'total_bill_cost', 'is_approved'));
    }



    public function active_add_items(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $comCode = auth()->user()->com_code;

        $item_type = ItemCard::where(['item_code' => $request->item_code])->value('item_type');
        $batch = Batch::where(['item_code' => $request->item_code, 'production_date' => $request->production_date, 'end_date' => $request->end_date, 'unit_price' => $request->price*100, 'store_id' => $request->store_id])->first();
        $bill_data = GeneralReturnSalesOrder::where(['auto_serial' => $request->auto_serial])->first();
        $is_approved = $bill_data->is_approved;


        if (!$bill_data) {
            return;
        }

        if (!$batch) {
            $batch = $this->createBatch($request);
        }

        $quantity_before_movement = Batch::where(['item_code' => $request->item_code, 'com_code' => $comCode])->sum('quantity');

        $bill_details = $this->createDetails($request, $item_type, $batch->id);

        $batch->update([
            'quantity' => $batch->quantity + $request->quantity,
            'total_cost' => ($batch->quantity + $request->quantity) * $batch->unit_price,
        ]);

        //movement in item table
        $this->itemmovment($request, $quantity_before_movement, $bill_details);


       $this->updateInItemCard($request);


        $bill_details = GeneralReturnSalesOrdersDetails::where(['com_code' => $comCode, 'bill_auto_serial' => $request->auto_serial])->get();
        if ($bill_details == null) {
            return;
        }

        foreach ($bill_details as $item) {
            $item['item_name'] = ItemCard::select()->where(['item_code' => $item->item_code, 'com_code' => $comCode])->value('name');
            $item['unit_name'] = Unit::where(['id' => $item->unit_id, 'com_code' => $comCode])->value('name');

            if ($item->normal_sale === "0")
            {
                $item['sale_type_name'] = 'جمله';
            }
            if ($item->normal_sale == 1)
            {
                $item['sale_type_name'] = 'نص جمله';
            }
            {
                $item['sale_type_name'] = 'قطاعى';
            }
        }

        return view('admin.general_return_sales_orders.get_add_items', compact('bill_details', 'is_approved'));
    }

    private function createDetails($request, $item_type, $batch_id)
    {
        $comCode = auth()->user()->com_code;
        $bill_details = GeneralReturnSalesOrdersDetails::create([
            'invoice_date' => $request->date,
            'item_code' => $request->item_code,
            'isparentunit' => $request->parent_unit,
            'unit_id' => $request->unit_id,
            'batch_id' => $batch_id,
            'sale_type' => $request->sale_type,
            'quantity' => $request->quantity,
            'unit_price' => $request->price * 100,
            'total_price' => $request->total_price * 100,
            'production_date' => $request->production_date,
            'end_date' => $request->end_date,
            'bill_auto_serial' => $request->auto_serial,
            'added_by' => auth()->user()->id,
            'com_code' => $comCode,
            'item_card_type' => $item_type,
        ]);

        return $bill_details;
    }

    private function createBatch($request)
    {
        $comCode = auth()->user()->com_code;
        $auto_serial = Batch::max('auto_serial');

        $auto_serial = $auto_serial == null ? 1 : $auto_serial + 1;

        $batch = Batch::create([
            'auto_serial' => $auto_serial,
            'store_id' => $request->store_id,
            'item_code' => $request->item_code,
            'unit_id' => $request->unit_id,
            'unit_price' => $request->price * 100,
            'quantity' => 0,
            'total_cost' => 0,
            'sale_type' => $request->sale_type,
            'production_date' => $request->production_date,
            'end_date' => $request->end_date,
            'added_by' => auth()->user()->id,
            'com_code' => $comCode,
        ]);

        return $batch;
    }

    private function itemmovment($request, $quantity_before_movement, $bill_details)
    {
        $comCode = auth()->user()->com_code;
        $quantity_after_movement = Batch::where(['item_code' => $request->item_code, 'com_code' => $comCode])->sum('quantity');
        $customer_name = Customer::where(['com_code' => $comCode, 'customer_code' => $request->customer_code])->value('name');

        $item_movement['item_code'] = $request->item_code;
        $item_movement['date'] = date('Y-m-d');
        $item_movement['com_code'] = $comCode;
        $item_movement['movement_type'] = 4;
        $item_movement['added_by'] = auth()->user()->id;
        $item_movement['quantity_after_movement'] = $quantity_after_movement;
        $item_movement['quantity_before_movement'] = $quantity_before_movement;
        $item_movement['table_code'] = $request->auto_serial;
        $item_movement['table_details_code'] = $bill_details->id;
        $item_movement['byan'] = "مرتجع مبيعات من  " . "" . $customer_name;
        ItemMovement::create($item_movement);
    }

    private function updateInItemCard($request)
    {
        $comCode = auth()->user()->com_code;
        $item_card_data = ItemCard::select('id', 'quantity', 'retail_unit_to_parent', 'all_retail_quantity')->where(['item_code' => $request->item_code, 'com_code' => $comCode])->first();

        if ($request->parent_unit == 1) {

            $new_quantity = $item_card_data->quantity + $request->quantity;

            $item_card_data->update([
                'quantity' => $new_quantity,
                'all_retail_quantity' => $new_quantity * $item_card_data->retail_unit_to_parent,
            ]);
        }
        if ($request->parent_unit == 0)
        {
            $new_quantity = $item_card_data->all_retail_quantity + $request->quantity;

            $item_card_data->update([
                'all_retail_quantity' => $new_quantity,
                'quantity' => $new_quantity / $item_card_data->retail_unit_to_parent,
            ]);
        }
    }

}