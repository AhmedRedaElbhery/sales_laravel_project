<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Store;
use App\Models\SupplierOrders;
use App\Models\Suppliers;
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
        $data = SupplierOrders::where(['com_code' => $comCode,'order_type'=>2])->orderby('id', 'DESC')->paginate(11);

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