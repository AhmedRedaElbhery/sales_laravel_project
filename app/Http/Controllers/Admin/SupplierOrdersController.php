<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveBillRequest;
use App\Http\Requests\SupplierOrderRequest;
use App\Models\Accounts;
use App\Models\Admin;
use App\Models\AdminShifts;
use App\Models\Batche;
use App\Models\ItemCard;
use App\Models\ItemMovement;
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
        $comCode = auth()->user()->com_code;
        $data = SupplierOrders::where(['com_code' => $comCode,'order_type'=>1])->orderby('id', 'DESC')->paginate(11);

        foreach ($data as $item) {
            $item['store_name'] = Store::where('id', $item['store_id'])->value('name');
            $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
            $item['supplier_name'] = Suppliers::where(['supplier_code' => $item->supplier_code, 'com_code' => $comCode])->value('name');
            if ($item->updated_at && $item->updated_at  != null) {
                $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
            }
        }

        return view('admin.supplier_orders.index', compact('data'));
    }


    public function create()
    {
        $comCode = auth()->user()->com_code;
        $suppliers = Suppliers::select('name', 'supplier_code')->where(['com_code' => $comCode])->get();
        $stores = Store::select('name', 'id')->where(['com_code' => $comCode, 'active' => 1])->get();
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
        $comCode = auth()->user()->com_code;
        $serial = SupplierOrders::max('auto_serial');


        $data['auto_serial'] = $serial == null ? 1 : $serial + 1;

        $accountNumber = Suppliers::where(['supplier_code' => $request->supplier_code, 'com_code' => $comCode])->value('account_number');

        $data['order_date'] = $request->order_date;
        $data['store_id'] = $request->store;
        $data['pill_type'] = $request->pill_type;
        $data['notes'] = $request->notes;
        $data['doc_number'] = $request->doc_number;
        $data['supplier_code'] = $request->supplier_code;

        $data['added_by'] = auth()->user()->id;
        $data['com_code'] = $comCode;
        $data['account_number'] = $accountNumber;
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
        $comCode = auth()->user()->com_code;
        $data = SupplierOrders::find($id);

        if (empty($data)) {
            return redirect()->route('supplier_orders.index');
        }

        $data['supplier_name'] = Suppliers::where('account_number', $data['account_number'])->value('name');
        $data['store_name'] = Store::where('id', $data['store_id'])->value('name');

        $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');

        if ($data['updated_by'] != null && $data['updated_by'] > 0) {
            $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
        }


        $details = SupplierOrdersDetails::where(['supplier_auto_serial' => $data['auto_serial'], 'com_code' => $data['com_code'], 'order_type' => $data['order_type']])->get();

        foreach ($details as $unit) {

            $unit['item_name'] = ItemCard::where(['item_code' => $unit->item_code])->value('name');
            $unit['unit_name'] = Unit::where(['id' => $unit->unit_id])->value('name');

            $unit['added_by_admin'] = Admin::where('id', $unit->added_by)->value('name');

            if ($unit['updated_by'] != null && $unit['updated_by'] > 0) {
                $unit['updated_by_admin'] = Admin::where('id', $unit->updated_by)->value('name');
            }
        }

        $shift = AdminShifts::where(['com_code' => $comCode, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
        if ($shift != null) {
            $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
            $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');
        }

        $items = [];

        if ($data['is_approved'] != 1) {

            $items = ItemCard::select('name', 'item_code', 'item_type')->where(['com_code' => $comCode, 'active' => 1])->get();
        }

        return view('admin.supplier_orders.details', compact('data', 'details', 'items', 'shift'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comCode = auth()->user()->com_code;
        $suppliers = Suppliers::select('name', 'supplier_code')->where(['com_code' => $comCode])->get();
        $stores = Store::select('name', 'id')->where(['com_code' => $comCode, 'active' => 1])->get();
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
        $comCode = auth()->user()->com_code;

        $data = SupplierOrders::where(['id' => $id, 'com_code' => $comCode])->first();
        $accountNumber = Suppliers::where(['supplier_code' => $request->supplier_code, 'com_code' => $comCode])->value('account_number');

        $data->update([
            'supplier_code' => $request->supplier_code,
            'pill_type' => $request->pill_type,
            'doc_number' => $request->doc_number,
            'store_id' => $request->store,
            'account_number' => $accountNumber,
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

    public function destroyDetails($id)
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
        if (!$request->ajax()) {
            return;
        }

        $comCode = auth()->user()->com_code;
        $itemCode = $request->item_code;

        $data = ItemCard::where(['item_code' => $itemCode, 'com_code' => $comCode])->first();

        $data['parent_unit_name'] = Unit::where(['id' => $data['parent_unit_id']])->value('name');
        if ($data['has_retail_unit'] == 1) {
            $data['retail_unit_name'] = Unit::where(['id' => $data['retail_unit_id']])->value('name');
        }

        return view('admin.supplier_orders.getUnits', compact('data'));
    }

    public function addUnits(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $comCode = auth()->user()->com_code;
        $parentData = SupplierOrders::select('is_approved', 'order_date', 'tax_value', 'discount_value')->where(['auto_serial' => $request->autoserialparent, 'com_code' => $comCode, 'order_type' => 1])->first();

        if (!$parentData || $parentData->is_approved == 1) {
            return;
        }

        $data['supplier_auto_serial'] = $request->autoserialparent;
        $data['order_type'] = 1;
        $data['item_code'] = $request->item_card;
        $data['delivered_quantity'] = $request->quantity;
        $data['unit_price'] = $request->price * 100;
        $data['total_price'] = $request->total_price * 100;
        $data['com_code'] = $comCode;
        $data['order_date'] = $parentData->order_date;
        $data['isparentunit'] = $request->isparent;
        $data['unit_id'] = $request->unit;
        $data['item_card_type'] = $request->type;
        $data['added_by'] = auth()->user()->id;

        if ($request->type == 2) {
            $data['production_date'] = $request->production_date;
            $data['end_date'] = $request->end_date;
        }

        SupplierOrdersDetails::create($data);

        $total = SupplierOrdersDetails::where(['com_code' => $comCode, 'order_type' => 1, 'supplier_auto_serial' => $request->autoserialparent])->sum('total_price');
        SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'order_type' => 1, 'com_code' => $comCode])->update([
            'updated_by' => auth()->user()->id,
            'total_before_discount' => $total,
            'total_cost' => $total - $parentData->discount_value + $parentData->tax_value,
        ]);

        echo json_encode('done');
    }

    public function editItem(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }
        $comCode = auth()->user()->com_code;
        $isapproved = SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'com_code' => $comCode, 'order_type' => 1])->value('is_approved');

        if ($isapproved == 1) {
            return;
        }

        $itemData = SupplierOrdersDetails::find($request->id);
        $itemCardData = ItemCard::select('has_retail_unit', 'retail_unit_id', 'parent_unit_id')->where(['item_code' => $itemData->item_code, 'com_code' => $comCode])->first();
        $itemCards = ItemCard::where(['active' => 1, 'com_code' => $comCode])->get();

        $itemCardData->parent_unit_name = Unit::where('id', $itemCardData->parent_unit_id)->value('name');
        if ($itemCardData->has_retail_unit == 1) {
            $itemCardData->retail_unit_name = Unit::where('id', $itemCardData->retail_unit_id)->value('name');
        }
        return view('admin.supplier_orders.edititem', compact('isapproved', 'itemCardData', 'itemData', 'itemCards'));
    }


    public function updateItem(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $comCode = auth()->user()->com_code;
        $parentData = SupplierOrders::select('is_approved', 'order_date', 'tax_value', 'discount_value')->where(['auto_serial' => $request->autoserialparent, 'com_code' => $comCode, 'order_type' => 1])->first();
        if ($parentData->is_approved == 1) {
            return;
        }
        SupplierOrdersDetails::where('id', $request->id)->update([
            'delivered_quantity' => $request->quantity,
            'unit_price'         => $request->price * 100,
            'total_price'        => $request->total_price * 100,
            'isparentunit'       => $request->isparent,
            'unit_id'            => $request->unit,
            'production_date'    => $request->production_date,
            'end_date'           => $request->end_date,
        ]);

        $total = SupplierOrdersDetails::where(['com_code' => $comCode, 'order_type' => 1, 'supplier_auto_serial' => $request->autoserialparent])->sum('total_price');
        SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'order_type' => 1, 'com_code' => $comCode])->update([
            'updated_by' => auth()->user()->id,
            'total_before_discount' => $total,
            'total_cost' => $total - $parentData->discount_value + $parentData->tax_value,
        ]);

        echo json_encode('done');
    }


    public function modelApprove(ApproveBillRequest $request)
    {
        if (!$request->ajax()) {
            return;
        }


        $comCode = auth()->user()->com_code;
        $autoSerial = $request->autoserialparent;

        $taxPercent = $request->tax_percent;
        $taxValue = $request->tax_value;
        $discount_percent = $request->discount_percent;
        $discount_value = $request->discount_value;

        $whatPaid = $request->what_paid;
        $whatRemain = $request->what_remain;

        $totalValue = $request->total_value;

        $data = SupplierOrders::where(['auto_serial' => $autoSerial, 'com_code' => $comCode])->first();
        $supplierName = Suppliers::where(['account_number' => $data->account_number])->value('name');

        if ($data->is_approved == 1) {
            return response()->json([
                'status' => false,
                'message' => 'هذه الفاتورة معتمدة من قبل',
                'redirect' => route('supplier_orders.show', $data->id),
            ]);
        }

        $allGood = $this->checkOnBill($autoSerial, $data, $whatPaid, $totalValue, $comCode);

        if ($allGood instanceof \Illuminate\Http\JsonResponse) {
            return $allGood;
        }

        $shift = $this->checkOnShift($data, $whatPaid, $comCode);

        if ($shift instanceof \Illuminate\Http\JsonResponse) {
            return $shift;
        }

        $flage = $data->update([
            'is_approved' => 1,
            'discount_percent' => $discount_percent,
            'discount_value' => $discount_value * 100,
            'tax_percent' => $taxPercent,
            'tax_value' => $taxValue * 100,
            'total_cost' => $totalValue * 100,
            'what_paid' => $whatPaid * 100,
            'what_remain' => $whatRemain * 100,
            'money_for_account' => $whatPaid * 100,
            'updated_by' => auth()->user()->id,
        ]);


        if(!$flage)
        {
            return;
        }

        //money movement
        if ($whatPaid > 0) {
            $this->moneyTransaction($data, $whatPaid, $shift, $comCode);
        }

        //items and quantity movement
        $items = SupplierOrdersDetails::where(['supplier_auto_serial' => $autoSerial, 'com_code' => $comCode])->get();
        foreach ($items as $item) {
            $itemCard = ItemCard::where(['com_code' => $comCode, 'item_code' => $item->item_code])->first();
            $quantityBeforeMovement = Batche::where(['com_code' => $comCode, 'item_code' => $item->item_code])->sum('quantity');

            //convert the coming unit to be a parent unit to store all item using parent units
            if ($item->isparentunit == 1) {
                $quantity = $item->delivered_quantity;
                $unitPrice = $item->unit_price;
            } else {

                $quantity = $item->delivered_quantity / $itemCard->retail_unit_to_parent;
                $unitPrice = $itemCard->retail_unit_to_parent * $item->unit_price;
            }


            //movment in batche table
            $this->addBatche($data, $item, $autoSerial, $quantity, $unitPrice, $comCode);

            //add the movment in itemMovment table
            $this->addItemMovment($item, $autoSerial, $quantityBeforeMovement, $supplierName, $comCode);

            //update the price and quantity to the new one
            $this->updateItemData($itemCard, $item);
        }


        return response()->json([
            'status' => true,
            'message' => 'تم اعتماد الفاتورة بنجاح',
            'redirect' => route('supplier_orders.index'),
        ]);
    }

    private function checkOnBill($autoSerial, $data, $whatPaid, $totalValue, $comCode)
    {
        $exist = SupplierOrdersDetails::where(['supplier_auto_serial' => $autoSerial, 'com_code' => $comCode])->exists();

        if (!$exist) {
            return response()->json([
                'status' => false,
                'message' => 'لا يمكن اعتماد هذه الفاتوره لانها لاتحتوى على اصناف ',
                'redirect' => route('supplier_orders.show', $data->id),
            ]);
        }

        if ($data->pill_type == 0) {
            if ($whatPaid < $totalValue) {
                return response()->json([
                    'status' => false,
                    'message' => ' الفاتوره كاش ولا يمكن ان يكون المبلغ المدفوع افل من الاجمالى',
                ]);
            }
        } else {

            if ($whatPaid == $totalValue) {
                return response()->json([
                    'status' => false,
                    'message' => ' الفاتوره اجل ولا يمكن ان يكون المبلغ المدفوع كاملا',

                ]);
            }
        }
    }


    private function checkOnShift($data, $whatPaid, $comCode)
    {
        $shift = AdminShifts::where(['com_code' => $comCode, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
        if ($shift == null) {
            return response()->json([
                'status' => false,
                'message' => ' لا يوجد شفت مفتوح',
                'redirect' => route('supplier_orders.show', $data->id),
            ]);
        }

        $shift->treasuries_name = Treasuries::where(['id' => $shift->treasuries_id])->value('name');
        $shift->treasuries_balance = TreasuriesTransaction::where(['shift_id' => $shift->id, 'treasuries_id' => $shift->treasuries_id])->sum('money');

        $treasuriesBalance = $shift->treasuries_balance / 100;

        if ($whatPaid > $treasuriesBalance) {
            return response()->json([
                'status' => false,
                'message' => ' الرصيد المتاح لا يسمح بالدفع',
                'redirect' => route('supplier_orders.show', $data->id),
            ]);
        }

        return $shift;
    }

    private function moneyTransaction($data, $whatPaid, $shift, $comCode)
    {

        //get the treasury
        $treasuries = Treasuries::where(['id' => $shift->treasuries_id, 'com_code' => $comCode])->first();
        if ($treasuries->last_isal_exchange == null) {
            $treasuries->last_isal_exchange = 0;
        }

        //add the transaction on table transactions
        TreasuriesTransaction::create([
            'treasuries_id' => $shift->treasuries_id,
            'bill_code' => $data->auto_serial,
            'is_approved' => 1,
            'shift_id' => $shift->id,
            'com_code' => $comCode,
            'money' => $whatPaid * (-100),
            'isal_number' => $treasuries->last_isal_exchange + 1,
            'date' => date('Y-m-d'),
            'byan' => 'فاتوره مشتريات',
            'move_type' => 1,
            'account_number' => $data->account_number,
            'money_for_account' => $whatPaid * (100),
            'added_by' => auth()->user()->id,
        ]);

        //update the last isal in treasury
        $treasuries->update([
            'last_isal_exchange' => $treasuries->last_isal_exchange + 1,
        ]);

        //add the money in accounts and supplier tables
        $accountData = Accounts::where(['account_number' => $data->account_number, 'com_code' => $comCode, 'is_parent' => 0])->first();

        $moneyForAccountTransaction = TreasuriesTransaction::where(['account_number' => $data->account_number, 'com_code' => $comCode])->sum('money_for_account');

        $theFinalBalance = $accountData->start_balance + $moneyForAccountTransaction;

        $accountData->update([
            'current_balance' => $theFinalBalance,
        ]);

        $supplier = Suppliers::where(['account_number' => $data->account_number, 'com_code' => $comCode])->first();
        $supplier->update([
            'current_balance' => $theFinalBalance,
        ]);
    }

    private function addBatche($data, $item, $autoSerial, $quantity, $unitPrice, $comCode)
    {
        if ($item->production_date != null && $item->end_date != null) {
            $batcheExist = Batche::where(['item_code' => $item->item_code, 'end_date' => $item->end_date, 'production_date' => $item->production_date, 'store_id' => $data->store_id, 'com_code' => $comCode, 'unit_price' => $unitPrice])->first();
        } else {
            $batcheExist = Batche::where(['item_code' => $item->item_code, 'store_id' => $data->store_id, 'com_code' => $comCode, 'unit_price' => $unitPrice])->first();
        }
        if ($batcheExist) {
            $batcheExist->update([
                'quantity' => $batcheExist->quantity + $quantity,
                'total_cost' => $batcheExist->total_cost + ($item->delivered_quantity * $item->unit_price),
                'updated_by' => auth()->user()->id,
            ]);

            $batch = $batcheExist;
        } else {
            $batche['auto_serial'] = $autoSerial;
            $batche['store_id'] = $data->store_id;
            $batche['item_code'] = $item->item_code;
            $batche['unit_id'] = $item->unit_id;
            $batche['unit_price'] = $unitPrice;
            $batche['quantity'] = $quantity;
            $batche['total_cost'] = $item->total_price;
            $batche['production_date'] = $item->production_date;
            $batche['end_date'] = $item->end_date;
            $batche['com_code'] = auth()->user()->com_code;
            $batche['added_by'] = auth()->user()->id;
            $batch = Batche::create($batche);
        }

        $item->update([
            'batch_id' => $batch->id,
        ]);
    }


    private function addItemMovment($item, $autoSerial, $quantityBeforeMovement, $supplierName, $comCode)
    {
        //movement in item table
        $quantity_after_movement = Batche::where(['com_code' => $comCode, 'item_code' => $item->item_code])->sum('quantity');
        $itemMovement['date'] = date('Y-m-d');
        $itemMovement['com_code'] = $comCode;
        $itemMovement['movement_type'] = 1;
        $itemMovement['added_by'] = auth()->user()->id;
        $itemMovement['quantity_after_movement'] = $quantity_after_movement;
        $itemMovement['quantity_before_movement'] = $quantityBeforeMovement;
        $itemMovement['item_code'] = $item->item_code;
        $itemMovement['table_code'] = $autoSerial;
        $itemMovement['table_details_code'] = $item->id;
        $itemMovement['byan'] = " مشتريات من مورد "  . "" . $supplierName;
        ItemMovement::create($itemMovement);
    }


    private function updateItemData($itemCard, $item)
    {

        // update the quantity first

        $currentQuantity = $itemCard->quantity;

        if ($item->isparentunit == 1) {
            $quantity = $item->delivered_quantity;
        } else {
            $quantity = $item->delivered_quantity / $itemCard->retail_unit_to_parent;
        }

        $itemCard->update([
            'quantity' => $currentQuantity + $quantity,
            'all_retail_quantity' => ($currentQuantity + $quantity) * $itemCard->retail_unit_to_parent,
        ]);

        //update the new price of item if that item does not have fixed price

        if ($itemCard->has_fixed_price != 0) {
            return;
        }

        if ($item->isparentunit == 1) {

            $unitPrice = $item->unit_price;
            $retailUnitPrice = $item->unit_price /  $itemCard->retail_unit_to_parent;
        } else {

            $unitPrice = $itemCard->retail_unit_to_parent * $item->unit_price;
            $retailUnitPrice = $item->unit_price;
        }

        $itemCard->update([
            'retail_cost_price' => $retailUnitPrice,
            'cost_price' => $unitPrice,
        ]);
    }
}