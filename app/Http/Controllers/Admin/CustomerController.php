<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomersRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Accounts;
use App\Models\AccountType;
use App\Models\Admin;
use App\Models\AdminPanalSettings;
use App\Models\Customer;
use App\Enums\AccountTypes;
use App\Enums\BalanceStatus;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = Customer::where(['com_code' => $com_code])->orderby('id', 'DESC')->paginate(5);

        foreach ($data as $item) {

            $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

            $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

            if ($item->updated_by > 0 && $item->updated_by != null) {
                $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
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

        $data['customer_code'] = ($customer_code ?? 0) + 1;
        $data['account_number'] = ($account_number ?? 0) + 1;
        $data['address'] = $request->address;

        $data['start_balance'] = BalanceStatus::Balanced->value;

        if (($request->start_balance_status == BalanceStatus::Debtor->value || $request->start_balance_status == BalanceStatus::Creditor->value) && $request->start_balance == 0) {
            return redirect()->back()->with('error', 'ادخل قيمه صحيحه لرصيد الحساب')->withInput();
        }

        if ($request->start_balance_status == BalanceStatus::Creditor->value && $request->start_balance > 0) {
            $data['start_balance'] = $request->start_balance * (100);
        }
        if ($request->start_balance_status == BalanceStatus::Creditor->value && $request->start_balance < 0) {
            $data['start_balance'] = $request->start_balance * (-100);
        }

        if ($request->start_balance_status == BalanceStatus::Debtor->value && $request->start_balance < 0) {
            $data['start_balance'] = $request->start_balance * (100);
        }
        if ($request->start_balance_status == BalanceStatus::Debtor->value && $request->start_balance > 0) {
            $data['start_balance'] = $request->start_balance * (-100);
        }

        $data['name'] = $request->name;
        $data['com_code'] = auth()->user()->com_code;
        $data['added_by'] = auth()->user()->id;
        $data['date'] = date('Y-m-d');
        $data['notes'] = $request->notes;
        $data['active'] = $request->active;
        $data['start_balance_status'] = $request->start_balance_status;
        $data['current_balance'] = $data['start_balance'];


        Customer::create($data);


        $data['is_archived'] = !$request->active;

        $data['account_type'] = AccountTypes::Customer->value;
        $data['is_parent'] = 0;
        $data['other_table_fk'] =  $data['customer_code'];
        $data['parent_account_number'] = AdminPanalSettings::where('com_code', $data['com_code'])->value('customer_parent_account_number');
        Accounts::create($data);

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
        $data = Customer::find($id);
        return view('admin.customers.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $data = Customer::find($id);
        $exists = Customer::where(['name' => $request->name])->where('id', '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'هذا الاسم موجود بالفعل')->withInput();
        }

        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['notes'] = $request->notes;
        $data['active'] = $request->active;

        $data->save();

        $is_archived = !$request->active;

        Accounts::where(['other_table_fk' => $data->customer_code, 'account_number' => $data['account_number'], 'com_code' => $data['com_code']])
            ->update([
                'name' => $request->name,
                'is_archived' =>  $is_archived,
                'notes' => $request->notes,
                'updated_by' => auth()->user()->id,
            ]);

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $code = Customer::select('customer_code', 'account_number', 'com_code')->where(['id' => $id])->first();
        $id_account = Accounts::where(['other_table_fk' => $code['customer_code'], 'account_type' => AccountTypes::Customer->value, 'account_number' => $code['account_number'], 'com_code' => $code['com_code']])->value('id');
        Customer::destroy($id);
        Accounts::destroy($id_account);
        return redirect()->route('customers.index');
    }
}