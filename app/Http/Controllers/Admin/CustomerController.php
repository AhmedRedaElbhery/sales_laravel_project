<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomersRequest;
use App\Models\Accounts;
use App\Models\AccountType;
use App\Models\Admin;
use App\Models\AdminPanalSettings;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::orderby('id', 'DESC')->paginate(5);

        if (!empty($data)) {

            foreach ($data as $item) {

                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

                $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.customers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomersRequest $request)
    {
        $customer_code = Customer::max('customer_code');
        $account_number = Accounts::max('account_number');
        $exist = Customer::where(['name' => $request->name])->exists();

        if ($exist) {
            return redirect()->back()->with('error', 'الاسم موجود بالفعل')->withInput();
        }

        if ($customer_code == null) {
            $data['customer_code'] = 1;
        } else {
            $data['customer_code'] = $customer_code + 1;
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
        $data['current_balance'] = 0;
        $data['start_balance_status'] = $request->start_balance_status;


        $flage = Customer::create($data);


        if ($flage) {
            $data['is_archived'] = $request->active;
            $data['account_type'] = 3;
            $data['is_parent'] = 0;
            $data['other_table_fk'] =  $data['customer_code'];
            $data['parent_account_number'] = AdminPanalSettings::select('customer_parent_account_number')->where('com_code', $data['com_code'])->first()?->customer_parent_account_number;
            Accounts::create($data);
        }

        return redirect()->route('customers.index');
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
        $code = Customer::select('customer_code')->where(['id'=>$id])->value('customer_code');
        Customer::destroy($id);
        $id_account = Accounts::select('id')->where(['other_table_fk'=>$code])->value('id');
        Accounts::destroy($id_account);
        return redirect()->route('customers.index');

    }
}