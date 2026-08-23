<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MoveType;
use App\Events\BillCreated;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Admin;
use App\Models\AdminPanalSettings;
use App\Models\AdminShifts;
use App\Models\Batch;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\ItemCard;
use App\Models\ItemMovement;
use App\Models\SalesBills;
use App\Models\SalesBillsDetails;
use App\Models\SalesMaterialType;
use App\Models\Store;
use App\Models\Treasuries;
use App\Models\TreasuriesTransaction;
use App\Models\Unit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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



    public function mirrorgetUnits(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }
        $com_code = auth()->user()->com_code;
        $item_code = $request->item_code;

        $data = ItemCard::where(['item_code' => $item_code, 'com_code' => $com_code])->first();
        if ($data['has_retail_unit'] == 1) {
            $data['parent_unit_name'] = Unit::where(['id' => $data['parent_unit_id']])->value('name');
            $data['retail_unit_name'] = Unit::where(['id' => $data['retail_unit_id']])->value('name');
        } else {
            $data['parent_unit_name'] = Unit::where(['id' => $data['parent_unit_id']])->value('name');
        }
        return view('admin.sales_bills.mirrorGetUnits', compact('data'));
    }

    public function mirror_get_batchs(Request $request)
    {
        if (!$request->ajax()) {

            return;
        }

        $com_code = auth()->user()->com_code;
        $item_code = $request->item_code;
        $item_type = $request->item_type;
        $unit_id = $request->unit_id;
        $store_id = $request->store_id;


        if ($item_type == 2) {
            $batchs_data = Batch::where(['item_code' => $item_code, 'unit_id' => $unit_id, 'store_id' => $store_id, 'com_code' => $com_code])->orderby('production_date', 'ASC')->get();
        } else {
            $batchs_data = Batch::where(['item_code' => $item_code, 'unit_id' => $unit_id, 'store_id' => $store_id, 'com_code' => $com_code])->get();
        }
        return view('admin.sales_bills.mirrorGetBatchs', compact('batchs_data'));
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

            return view('admin.sales_bills.mirror_get_add_items', compact('data'));
        }
    }





    ///////////////////////////////////////////////////////////////////////////////

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

    public function get_batchs(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }
        $com_code = auth()->user()->com_code;
        $item_code = $request->item_code;
        $item_type = $request->item_type;
        $unit_id = $request->unit_id;
        $store_id = $request->store_id;


        if ($item_type == 2) {
            $batchs_data = Batch::where(['item_code' => $item_code, 'unit_id' => $unit_id, 'store_id' => $store_id, 'com_code' => $com_code])->orderby('production_date', 'ASC')->get();
        } else {
            $batchs_data = Batch::where(['item_code' => $item_code, 'unit_id' => $unit_id, 'store_id' => $store_id, 'com_code' => $com_code])->get();
        }
        return view('admin.sales_bills.getBatchs', compact('batchs_data'));
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
                event(new BillCreated($data));

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

                $total_bill_cost = 0;
                $is_approved = $data->is_approved;

                return view('admin.sales_bills.active_model_items', compact('data', 'customers', 'delegates', 'items', 'stores', 'sales_material_types', 'shift', 'bill_details', 'total_bill_cost', 'is_approved'));
            }
        }
    }

    public function get_active_bill_data(Request $request)
    {
        $auto_serial = $request->auto_serial;
        $com_code = auth()->user()->com_code;

        $data = SalesBills::where(['com_code' => $com_code, 'auto_serial' => $auto_serial])->first();
        $is_approved = $data->is_approved;

        $customers = Customer::select('customer_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $delegates = Delegate::select('delegate_code', 'name')->where(['active' => 1, 'com_code' => $com_code])->get();
        $items = ItemCard::select('item_code', 'name', 'item_type')->where(['com_code' => $com_code])->get();
        $stores = Store::select('id', 'name')->where(['com_code' => $com_code])->get();
        $sales_material_types = SalesMaterialType::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();
        $bill_details = SalesBillsDetails::where(['com_code' => $com_code, 'bill_auto_serial' => $auto_serial])->get();
        if ($bill_details != null) {

            $total_bill_cost = 0;
            foreach ($bill_details as $item) {
                $item['item_name'] = ItemCard::select()->where(['item_code' => $item->item_code, 'com_code' => $com_code])->value('name');
                $item['unit_name'] = Unit::where(['id' => $item->unit_id, 'com_code' => $com_code])->value('name');
                if ($item->normal_sale === "0") {
                    $item['normal_sale_name'] = 'بيع عادى';
                } else if ($item->normal_sale == 1) {
                    $item['normal_sale_name'] = 'بونص';
                } else {
                    $item['normal_sale_name'] = 'دعايه';
                }
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
            $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
            $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
        }


        return view('admin.sales_bills.active_model_items', compact('data', 'customers', 'delegates', 'items', 'stores', 'sales_material_types', 'shift', 'bill_details', 'total_bill_cost', 'is_approved'));
    }

    public function active_add_items(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;

            $batche_data = Batch::where(['id' => $request->quantity_with_date])->first();
            $sale_bill_data = SalesBills::where(['auto_serial' => $request->auto_serial])->first();
            $is_approved = $sale_bill_data->is_approved;
            $item_type = ItemCard::where(['item_code' => $request->item_code])->value('item_type');

            if ($sale_bill_data) {

                if ($batche_data) {

                    if ($batche_data->quantity >= $request->quantity) {

                        $quantity_before_movement = Batch::where(['com_code' => $com_code, 'item_code' => $request->item_code])->sum('quantity');


                        $bill_details['customer_code'] = $request->customer_code;
                        $bill_details['delegate_code'] = $request->delegate_code;
                        $bill_details['invoice_date'] = $request->invoice_date;
                        $bill_details['sales_material_type'] = $request->sales_material_type;
                        $bill_details['normal_sale'] = $request->normal_sale;
                        $bill_details['store_id'] = $request->store_id;
                        $bill_details['item_code'] = $request->item_code;
                        $bill_details['isparentunit'] = $request->parent_unit;
                        $bill_details['unit_id'] = $request->unit_id;
                        $bill_details['batch_id'] = $request->quantity_with_date;
                        $bill_details['sale_type'] = $request->sale_type;
                        $bill_details['quantity'] = $request->quantity;
                        $bill_details['unit_price'] = $request->price * 100;
                        $bill_details['total_price'] = $request->total_price * 100;
                        $bill_details['bill_auto_serial'] = $request->auto_serial;
                        $bill_details['added_by'] = auth()->user()->id;
                        $bill_details['com_code'] = $com_code;
                        $bill_details['item_card_type'] = $item_type;


                        $bill_details = SalesBillsDetails::create($bill_details);

                        $batche_data->update([
                            'quantity' => $batche_data->quantity - $request->quantity,
                            'total_cost' => ($batche_data->quantity - $request->quantity) * $batche_data->unit_price,
                        ]);


                        //movement in item table
                        $quantity_after_movement = Batch::where(['com_code' => $com_code, 'item_code' => $request->item_code])->sum('quantity');
                        $customer_name = Customer::where(['com_code' => $com_code, 'customer_code' => $request->customer_code])->value('name');
                        $item_movement['date'] = date('Y-m-d');
                        $item_movement['com_code'] = auth()->user()->com_code;
                        $item_movement['movement_type'] = 4;
                        $item_movement['added_by'] = auth()->user()->id;
                        $item_movement['quantity_after_movement'] = $quantity_after_movement;
                        $item_movement['quantity_before_movement'] = $quantity_before_movement;
                        $item_movement['item_code'] = $request->item_code;
                        $item_movement['table_code'] = $request->auto_serial;
                        $item_movement['table_details_code'] = $bill_details->id;
                        $item_movement['byan'] = "مبيعات ل " . "" . $customer_name;
                        ItemMovement::create($item_movement);

                        if ($request->parent_unit == 1) {
                            $item_card_data = ItemCard::select('id', 'quantity', 'retail_unit_to_parent')->where(['item_code' => $request->item_code, 'com_code' => $com_code])->first();
                            $new_quantity = $item_card_data->quantity - $request->quantity;

                            $item_card_data->update([
                                'quantity' => $new_quantity,
                                'all_retail_quantity' => $new_quantity * $item_card_data->retail_unit_to_parent,
                            ]);
                        } else {
                            $item_card_data = ItemCard::select('id', 'retail_unit_to_parent', 'all_retail_quantity')->where(['item_code' => $request->item_code, 'com_code' => $com_code])->first();

                            $new_quantity = $item_card_data->all_retail_quantity - $request->quantity;

                            $item_card_data->update([
                                'all_retail_quantity' => $new_quantity,
                                'quantity' => $new_quantity / $item_card_data->retail_unit_to_parent,
                            ]);
                        }


                        $bill_details = SalesBillsDetails::where(['com_code' => $com_code, 'bill_auto_serial' => $request->auto_serial])->get();
                        if ($bill_details != null) {

                            foreach ($bill_details as $item) {
                                $item['item_name'] = ItemCard::select()->where(['item_code' => $item->item_code, 'com_code' => $com_code])->value('name');
                                $item['unit_name'] = Unit::where(['id' => $item->unit_id, 'com_code' => $com_code])->value('name');
                                if ($item->normal_sale === "0") {
                                    $item['normal_sale_name'] = 'بيع عادى';
                                } else if ($item->normal_sale == 1) {
                                    $item['normal_sale_name'] = 'بونص';
                                } else {
                                    $item['normal_sale_name'] = 'دعايه';
                                }
                                if ($item->normal_sale === "0") {
                                    $item['sale_type_name'] = 'جمله';
                                } else if ($item->normal_sale == 1) {
                                    $item['sale_type_name'] = 'نص جمله';
                                } else {
                                    $item['sale_type_name'] = 'قطاعى';
                                }
                            }
                        }

                        return view('admin.sales_bills.get_add_items', compact('bill_details', 'is_approved'));
                    } else {
                        return response()->json([
                            'message' => 'الكمية المطلوبة أكبر من الكمية المتاحة.'
                        ], 422);
                    }
                }
            }
        }
    }

    public function delete_item(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;



            $item_data = SalesBillsDetails::select('item_code', 'quantity', 'batch_id')->where(['id' => $request->record_id])->first();
            $batche_data = Batch::where(['id' => $item_data->batch_id])->first();
            $quantity_before_movement = Batch::where(['com_code' => $com_code, 'item_code' => $item_data->item_code])->sum('quantity');

            $batche_data->update([
                'quantity' => $batche_data->quantity + $item_data->quantity,
                'total_cost' => ($batche_data->quantity + $item_data->quantity) * $batche_data->unit_price,
            ]);

            //movement in item table
            $quantity_after_movement = Batch::where(['com_code' => $com_code, 'item_code' => $item_data->item_code])->sum('quantity');
            $customer_name = Customer::where(['com_code' => $com_code, 'customer_code' => $request->customer_code])->value('name');
            $item_movement['date'] = date('Y-m-d');
            $item_movement['com_code'] = auth()->user()->com_code;
            $item_movement['movement_type'] = 5;
            $item_movement['added_by'] = auth()->user()->id;
            $item_movement['quantity_after_movement'] = $quantity_after_movement;
            $item_movement['quantity_before_movement'] = $quantity_before_movement;
            $item_movement['item_code'] =  $item_data->item_code;
            $item_movement['table_code'] = $batche_data->auto_serial;
            $item_movement['table_details_code'] =  $item_data->batch_id;
            $item_movement['byan'] = "مرتجع من " . "" . $customer_name;
            ItemMovement::create($item_movement);

            if ($request->parent_unit == 1) {
                $item_card_data = ItemCard::select('id', 'quantity', 'retail_unit_to_parent')->where(['item_code' => $item_data->item_code, 'com_code' => $com_code])->first();
                $new_quantity = $item_card_data->quantity + $item_data->quantity;

                $item_card_data->update([
                    'quantity' => $new_quantity,
                    'all_retail_quantity' => $new_quantity * $item_card_data->retail_unit_to_parent,
                ]);
            } else {
                $item_card_data = ItemCard::select('id', 'retail_unit_to_parent', 'all_retail_quantity')->where(['item_code' => $item_data->item_code, 'com_code' => $com_code])->first();

                $new_quantity = $item_card_data->all_retail_quantity + $item_data->quantity;

                $item_card_data->update([
                    'all_retail_quantity' => $new_quantity,
                    'quantity' => $new_quantity / $item_card_data->retail_unit_to_parent,
                ]);
            }


            SalesBillsDetails::destroy($request->record_id);

            return response()->json([
                'message' => 'تم الحذف بنجاح',
            ]);
        }
    }

    public function active_delete_all_items(Request $request)
    {

        if ($request->ajax()) {

            $items = SalesBillsDetails::select('id', 'quantity', 'batch_id')->where(['bill_auto_serial' => $request->auto_serial])->get();

            foreach ($items as $item) {

                $batche_data = Batch::where(['id' => $item->batch_id])->first();

                $batche_data->update([
                    'quantity' => $batche_data->quantity + $item->quantity,
                    'total_cost' => ($batche_data->quantity + $item->quantity) * $batche_data->unit_price,
                ]);

                //item movement

                SalesBillsDetails::destroy($item->id);
            }

            return response()->json([
                'message' => 'تم الحذف بنجاح',
            ]);
        }
    }

    public function approve_active_bill(Request $request)
    {
        $com_code = auth()->user()->com_code;

        $data = SalesBills::where(['auto_serial' => $request->auto_serial, 'com_code' => $com_code])->first();

        if ($data->is_approved != 1) {

            $data->update([
                'discount_percent' => $request->discount_percent,
                'discount_value' => $request->discount_value * 100,
                'tax_percent' => $request->tax_percent,
                'tax_value' => $request->tax_value * 100,
                'total_cost' => $request->total_value * 100,
                'money_for_account' => $request->total_value * -100,
                'pill_type' => $request->bill_type,
                'what_paid' => $request->what_paid * 100,
                'what_remain' => $request->what_remain * 100,
                'notes' => $request->notes,
                'invoice_date' => $request->date,
                'customer_code' => $request->customer_code,
                'sales_material_type_id' => $request->sales_material_type_id,
                'delegate_code' => $request->delegate_code,
                'total_before_discount' => $request->total_before_discount,
                'is_approved' => 1,
                'updated_by' => auth()->user()->id,
            ]);


            if ($request->what_paid > 0) {

                $customer_account = Customer::where(['customer_code' => $request->customer_code, 'com_code' => $com_code])->first();


                $money_for_account_before_transaction = TreasuriesTransaction::where(['account_number' => $customer_account->account_number, 'com_code' => $com_code])->sum('money_for_account');
                $data->update([
                    'customer_balance_after_pill' => $money_for_account_before_transaction,
                ]);


                $shift = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
                if ($shift == null) {
                    return response()->json([
                        'status' => false,
                        'message' => ' لا يوجد شفت مفتوح',
                        'redirect' => route('sales_bills.index'),
                    ]);
                }

                $treasuries = Treasuries::where(['id' => $shift->treasuries_id, 'com_code' => $com_code])->first();
                if ($treasuries->last_isal_collect == null) {
                    $$treasuries->last_isal_collect = 0;
                }
                $transaction_id = TreasuriesTransaction::create([
                    'treasuries_id' => $shift->treasuries_id,
                    'bill_code' => $data->auto_serial,
                    'is_approved' => 1,
                    'shift_id' => $shift->id,
                    'com_code' => $com_code,
                    'money' => $request->what_paid * (100),
                    'isal_number' => $treasuries->last_isal_collect + 1,
                    'date' => date('Y-m-d'),
                    'byan' => 'فاتوره مبيعات',
                    'move_type' => MoveType::MoneyForSale->value,
                    'account_number' => $customer_account->account_number,
                    'from_account' => $request->customer_code,
                    'money_for_account' => $request->what_paid * (-100),
                    'added_by' => auth()->user()->id,
                ]);

                $data->update([
                    'treasuries_transaction_id' => $transaction_id->id,
                ]);

                $treasuries->update([
                    'last_isal_collect' => $treasuries->last_isal_collect + 1,
                ]);



                $customer_account_in_accounts = Accounts::where(['account_number' => $customer_account->account_number, 'com_code' => $com_code, 'is_parent' => 0])->first();

                $money_for_account_transaction = TreasuriesTransaction::where(['account_number' => $customer_account->account_number, 'com_code' => $com_code])->sum('money_for_account');

                $the_final_balance = $customer_account->start_balance + $money_for_account_transaction;

                $customer_account->update([
                    'current_balance' => $the_final_balance,
                ]);

                $customer_account_in_accounts->update([
                    'current_balance' => $the_final_balance,
                ]);

                $data->update([
                    'customer_balance_after_pill' => $the_final_balance,
                ]);
            }


            return response()->json([
                'status' => true,
                'message' => 'تم الاعتماد بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'الفاتوره معتمده من قبل',
            ]);
        }
    }

    public function print($auto_serial)
    {
        $data = SalesBills::where(['auto_serial' => $auto_serial, 'com_code' => auth()->user()->com_code])->first();
        $data->customer = Customer::where(['customer_code' => $data->customer_code])->first();
        $data->company = AdminPanalSettings::where(['com_code' => auth()->user()->com_code])->first();
        $data->sales_material_type_name = SalesMaterialType::where(['id' => $data->sales_material_type_id])->value('name');


        $details = SalesBillsDetails::where(['bill_auto_serial' => $auto_serial, 'com_code' => auth()->user()->com_code])->get();

        foreach ($details as $item) {
            $item->unit_name = Unit::where(['id' => $item->unit_id])->value('name');
            $item->item_name = ItemCard::where(['item_code' => $item->item_code, 'com_code' => auth()->user()->com_code])->value('name');
        }

        $css = file_get_contents(asset('assets/admin/css/print_invoice.css'));

        $pdf = Pdf::loadView('admin.sales_bills.print_bill', compact('data', 'details', 'css'));

        return $pdf->stream('Invoice_' . $data->auto_serial . '.pdf');
    }
}