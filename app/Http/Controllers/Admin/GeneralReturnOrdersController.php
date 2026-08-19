<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralReturnOrdersRequest;
use App\Http\Requests\UpdateGeneralReturnOrdersRequest;
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

class GeneralReturnOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comCode = auth()->user()->com_code;
        $data = SupplierOrders::where(['com_code' => $comCode, 'order_type' => OrderType::PurchaseReturnInvoice->value])->orderby('id', 'DESC')->paginate(11);

        foreach ($data as $item) {
            $item['store_name'] = Store::where('id', $item['store_id'])->value('name');
            $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
            $item['supplier_name'] = Suppliers::where(['supplier_code' => $item->supplier_code, 'com_code' => $comCode])->value('name');
            if ($item->updated_at && $item->updated_at  != null) {
                $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
            }
        }

        return view('admin.general_return_orders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comCode = auth()->user()->com_code;
        $suppliers = Suppliers::select('name', 'supplier_code')->where(['com_code' => $comCode])->get();
        $stores = Store::select('name', 'id')->where(['com_code' => $comCode, 'active' => 1])->get();
        return view('admin.general_return_orders.create', compact('suppliers', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralReturnOrdersRequest $request)
    {
        $comCode = auth()->user()->com_code;
        $serial = SupplierOrders::where(['order_type' => 2])->max('auto_serial');


        $accountNumber = Suppliers::where(['supplier_code' => $request->supplier_code, 'com_code' => $comCode])->value('account_number');

        if ($accountNumber == null) {
            return redirect()->back();
        }

        $orderData = [
            'auto_serial' => $serial == null ? 1 : $serial + 1,
            'order_date' => $request->order_date,
            'store_id' => $request->store,
            'pill_type' => $request->pill_type,
            'notes' => $request->notes,
            'supplier_code' => $request->supplier_code,
            'added_by' => auth()->user()->id,
            'com_code' => $comCode,
            'account_number' => $accountNumber,
            'order_type' => OrderType::PurchaseReturnInvoice->value,
        ];

        SupplierOrders::create($orderData);
        return redirect()->route('general_return_orders.index');
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

        return view('admin.general_return_orders.details', compact('data', 'details', 'items', 'shift'));
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
        return view('admin.general_return_orders.edit', compact('data', 'suppliers', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGeneralReturnOrdersRequest $request, $id)
    {
        $comCode = auth()->user()->com_code;

        $data = SupplierOrders::where(['id' => $id, 'com_code' => $comCode])->first();
        $accountNumber = Suppliers::where(['supplier_code' => $request->supplier_code, 'com_code' => $comCode])->value('account_number');

        $data->update([
            'supplier_code' => $request->supplier_code,
            'pill_type' => $request->pill_type,
            'account_number' => $accountNumber,
            'updated_by' => auth()->user()->id,
        ]);
        return redirect()->route('general_return_orders.show', $id);
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
        $items = SupplierOrdersDetails::where(['supplier_auto_serial' => $data->auto_serial, 'com_code' => $data->com_code, 'order_type' => OrderType::PurchaseReturnInvoice->value])->exists();
        if (!$items) {
            SupplierOrders::destroy($id);
        }
        return redirect()->route('general_return_orders.index');
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

        return view('admin.general_return_orders.getUnits', compact('data'));
    }

    public function getBatches(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $com_code = auth()->user()->com_code;
        $item_code = $request->item_code;
        $unit_id = $request->unit_id;
        $store_id = $request->store_id;

        $batches_data = Batche::where(['item_code' => $item_code, 'unit_id' => $unit_id, 'store_id' => $store_id, 'com_code' => $com_code])->orderby('production_date', 'ASC')->get();

        return view('admin.general_return_orders.getBatches', compact('batches_data'));
    }

    public function addUnits(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $comCode = auth()->user()->com_code;
        $parentData = SupplierOrders::select('is_approved', 'order_date', 'tax_value', 'discount_value')->where(['auto_serial' => $request->autoserialparent, 'com_code' => $comCode, 'order_type' => OrderType::PurchaseReturnInvoice->value])->first();

        if (!$parentData || $parentData->is_approved == 1) {
            return;
        }

        $quantity_before_movement = Batche::where(['com_code' => $comCode, 'item_code' => $request->item_card])->sum('quantity');

        $batche = $this->updateBatche($request);

        $data = [
            'supplier_auto_serial' => $request->autoserialparent,
            'order_type' => OrderType::PurchaseReturnInvoice->value,
            'item_code' => $request->item_card,
            'delivered_quantity' => $request->return_quantity,
            'unit_price' => $batche->unit_price,
            'total_price' => ($batche->unit_price * $request->return_quantity),
            'com_code' => $comCode,
            'order_date' => $parentData->order_date,
            'unit_id' => $request->unit,
            'added_by' => auth()->user()->id,
            'batch_id' => $request->batche,
        ];

        SupplierOrdersDetails::create($data);

        $total = SupplierOrdersDetails::where(['com_code' => $comCode, 'order_type' => OrderType::PurchaseReturnInvoice->value, 'supplier_auto_serial' => $request->autoserialparent])->sum('total_price');
        SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'order_type' => OrderType::PurchaseReturnInvoice->value, 'com_code' => $comCode])->update([
            'updated_by' => auth()->user()->id,
            'total_before_discount' => $total,
            'total_cost' => $total - $parentData->discount_value + $parentData->tax_value,
        ]);

        //update item card

        $item = $this->updateItemCardData($request);


        //item movment

        $this->addItemMovment($item, $request, $quantity_before_movement);


        echo json_encode('done');
    }

    public function editItem(Request $request)
    {

        if (!$request->ajax()) {
            return;
        }
        $comCode = auth()->user()->com_code;
        $isapproved = SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'com_code' => $comCode, 'order_type' => OrderType::PurchaseReturnInvoice->value])->value('is_approved');

        if ($isapproved == 1) {
            return;
        }

        $itemData = SupplierOrdersDetails::find($request->id);
        $itemCardData = ItemCard::select('has_retail_unit', 'retail_unit_id', 'parent_unit_id')->where(['item_code' => $itemData->item_code, 'com_code' => $comCode])->first();
        $itemCards = ItemCard::where(['active' => 1, 'com_code' => $comCode])->get();
        $batch = Batche::find($itemData->batch_id);

        $itemCardData->parent_unit_name = Unit::where('id', $itemCardData->parent_unit_id)->value('name');
        if ($itemCardData->has_retail_unit == 1) {
            $itemCardData->retail_unit_name = Unit::where('id', $itemCardData->retail_unit_id)->value('name');
        }
        return view('admin.general_return_orders.edititem', compact('isapproved', 'itemCardData', 'itemData', 'itemCards', 'batch'));
    }

    public function updateItem(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $comCode = auth()->user()->com_code;
        $parentData = SupplierOrders::select('is_approved', 'order_date', 'tax_value', 'discount_value')->where(['auto_serial' => $request->autoserialparent, 'com_code' => $comCode, 'order_type' => OrderType::PurchaseReturnInvoice->value])->first();
        if ($parentData->is_approved == 1) {
            return;
        }

        $oldDetails = SupplierOrdersDetails::find($request->id);

        $batchData = new Request([
            'batche' => $oldDetails->batch_id,
            'oldQuantity' => $oldDetails->delivered_quantity,
            'return_quantity' => $request->return_quantity,
        ]);


        SupplierOrdersDetails::where('id', $request->id)->update([
            'delivered_quantity' => $request->return_quantity,
            'total_price' => $request->return_quantity * $oldDetails->unit_price,
        ]);

        $total = SupplierOrdersDetails::where(['com_code' => $comCode, 'order_type' => OrderType::PurchaseReturnInvoice->value, 'supplier_auto_serial' => $request->autoserialparent])->sum('total_price');
        SupplierOrders::where(['auto_serial' => $request->autoserialparent, 'order_type' => OrderType::PurchaseReturnInvoice->value, 'com_code' => $comCode])->update([
            'updated_by' => auth()->user()->id,
            'total_before_discount' => $total,
            'total_cost' => $total - $parentData->discount_value + $parentData->tax_value,
        ]);



        $batch = $this->updateBatche($batchData);

        $item = $this->updateItemCardData($request, $oldDetails->delivered_quantity);

        echo json_encode('done');
    }


    private function updateBatche($request)
    {

        $batche = Batche::find($request->batche);

        if (($batche->quantity + $request->oldQuantity) < $request->return_quantity) {
            return;
        }

        $new_quantity = ($batche->quantity + $request->oldQuantity) - $request->return_quantity;
        $new_total = $batche->unit_price * $new_quantity;

        $batche->update([
            'quantity' => $new_quantity,
            'total_cost' => $new_total,
            'updated_by' => auth()->user()->id,
        ]);

        return $batche;
    }

    private function updateItemCardData($request, $oldQuantity = 0)
    {
        $item = ItemCard::select('id', 'item_code', 'quantity', 'retail_unit_to_parent', 'all_retail_quantity')->where(['item_code' => $request->item_card])->first();

        $newQuantity = 0;
        $retailNewQuantity = 0;

        if ($request->isparent == 1) {
            $newQuantity = ($item->quantity + $oldQuantity) - $request->return_quantity;
            $retailNewQuantity = $newQuantity * $item->retail_unit_to_parent;
        }

        if ($request->isparent == '0') {
            $retailNewQuantity = ($item->all_retail_quantity + $oldQuantity) - $request->return_quantity;
            $newQuantity = $retailNewQuantity / $item->retail_unit_to_parent;
        }

        $item->update([
            'quantity' => $newQuantity,
            'all_retail_quantity' => $retailNewQuantity,
        ]);
        return $item;
    }

    private function addItemMovment($item, $request, $quantity_before_movement)
    {
        $comCode = auth()->user()->com_code;
        $quantity_after_movement = Batche::where(['com_code' => $comCode, 'item_code' => $item->item_code])->sum('quantity');

        $item_movment = [
            'item_code' => $request->item_card,
            'movement_type' => 3,
            'table_code' =>  $request->autoserialparent,
            'table_details_code' => $request->item_card,
            'quantity_before_movement' => $quantity_before_movement,
            'quantity_after_movement' => $quantity_after_movement,

            'added_by' => auth()->user()->id,
            'com_code' => auth()->user()->com_code,
            'date' => now(),
            'byan' => "حركه نظير مرتجعات عام",
        ];

        ItemMovement::create($item_movment);
    }

    public function destroyDetails($id)
    {

        $data = SupplierOrdersDetails::find($id);

        $batch = Batche::find($data->batch_id);

        $batch->update([
            'quantity' => $batch->quantity + $data->delivered_quantity,
        ]);

        $isparent = Unit::where(['id' => $data->unit_id])->value('is_master');

        $item_card = ItemCard::where(['item_code' => $data->item_code, 'com_code' => auth()->user()->com_code])->first();


        $newQuantity = 0;
        $retailNewQuantity = 0;



        if ($isparent == 1) {
            $newQuantity = $item_card->quantity + $data->delivered_quantity;
            $retailNewQuantity = $item_card->retail_unit_to_parent * $newQuantity;
        }

        if ($isparent == '0') {
            $retailNewQuantity = $item_card->all_retail_quantity + $data->delivered_quantity;
            $newQuantity = $retailNewQuantity / $item_card->retail_unit_to_parent;
        }

        $item_card->update([
            'quantity' => $newQuantity,
            'all_retail_quantity' =>  $retailNewQuantity,
        ]);

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
}