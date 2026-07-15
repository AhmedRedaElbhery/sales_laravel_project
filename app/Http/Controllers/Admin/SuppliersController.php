<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuppliersRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Accounts;
use App\Models\Admin;
use App\Models\AdminPanalSettings;
use App\Models\SupplierCategory;
use App\Models\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = Suppliers::where(['com_code'=>$com_code])->orderby('id', 'DESC')->paginate(10);

        if (!empty($data)) {

            foreach ($data as $item) {

                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                $item['supplier_category_name'] = SupplierCategory::where(['id' => $item->supplier_category_id])->value('name');

                $item['supplier_category_name'] = SupplierCategory::where(['id' => $item->supplier_category_id])->value('name');

                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.suppliers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $supplier_category = SupplierCategory::select('id','name')->where(['com_code'=>$com_code, 'active'=>1])->get();
        return view('admin.suppliers.create',compact('supplier_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuppliersRequest $request)
    {
        $supplier_code = Suppliers::max('supplier_code');
        $account_number = Accounts::max('account_number');
        $exist = Suppliers::where(['name' => $request->name])->exists();

        if ($exist) {
            return redirect()->back()->with('error', 'الاسم موجود بالفعل')->withInput();
        }

        if ($supplier_code == null) {
            $data['supplier_code'] = 1;
        } else {
            $data['supplier_code'] = $supplier_code + 1;
        }

        if ($account_number == null) {
            $data['account_number'] = 1;
        } else {
            $data['account_number'] = $account_number + 1;
        }


        if (isset($request->address)) {
            $data['address'] = $request->address;
        }

        if ($request->start_balance_status == 1) {
            if ($request->start_balance > 0) {
                $data['start_balance'] = $request->start_balance * (-1);
            } elseif ($request->start_balance == 0) {
                return redirect()->back()->with('error', 'ادخل قيمه صحيحه لرصيد الحساب')->withInput();
            } else {
                $data['start_balance'] = $request->start_balance;
            }
        } elseif ($request->start_balance_status == 2) {
            if ($request->start_balance < 0) {
                $data['start_balance'] = $request->start_balance * (-1);
            } elseif ($request->start_balance == 0) {
                return redirect()->back()->with('error', 'ادخل قيمه صحيحه لرصيد الحساب')->withInput();
            } else {
                $data['start_balance'] = $request->start_balance;
            }
        } elseif ($request->start_balance_status == 3) {
            $data['start_balance'] = 0;
        }



        $data['name'] = $request->name;
        $data['com_code'] = auth()->user()->com_code;
        $data['added_by'] = auth()->user()->id;
        $data['date'] = date('Y-m-d');
        $data['notes'] = $request->notes;
        $data['active'] = $request->active;
        $data['supplier_category_id'] = $request->category_id;
        $data['current_balance'] = 0;
        $data['start_balance_status'] = $request->start_balance_status;


        $flage = Suppliers::create($data);

        if ($flage) {

            $data['is_archived'] = $request->active;
            $data['account_type'] = 2;
            $data['is_parent'] = 0;
            $data['other_table_fk'] =  $data['supplier_code'];
            $data['parent_account_number'] = AdminPanalSettings::select('supplier_parent_account_number')->where('com_code', $data['com_code'])->value('supplier_parent_account_number');
            Accounts::create($data);
        }

        return redirect()->route('suppliers.index');
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
        $data = Suppliers::find($id);
        $categories = SupplierCategory::select('id','name')->where(['active'=>1])->get();
        return view('admin.suppliers.edit', compact('data','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        $data = Suppliers::find($id);
        $exists = Suppliers::where(['name' => $request->name])->where('id', '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'هذا الاسم موجود بالفعل')->withInput();
        }

        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['notes'] = $request->notes;
        $data['active'] = $request->active;
        $data['supplier_category_id'] = $request->category_id;

        $flage = $data->save();

        if ($flage) {
            if($request->active == 1)
            {
                $is_archived = 0;
            }
            else{
                $is_archived = 1;
            }

            Accounts::where(['other_table_fk'=> $data->supplier_code ,'account_number'=>$data['account_number'],'com_code'=>$data['com_code'] ])
                ->update([
                    'name' => $request->name,
                    'is_archived' => $is_archived,
                    'notes' => $request->notes,
                    'updated_by' => auth()->user()->id,
                ]);
        }

        return redirect()->route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $code = Suppliers::select('supplier_code','account_number','com_code')->where(['id' => $id])->first();
        $id_account = Accounts::select('id')->where(['other_table_fk'=>$code['supplier_code'] , 'account_type'=>2,'account_number'=>$code['account_number'], 'com_code'=>$code['com_code'] ])->value('id');
        Suppliers::destroy($id);
        Accounts::destroy($id_account);
        return redirect()->route('suppliers.index');
    }
}