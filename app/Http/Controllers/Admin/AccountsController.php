<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountsRequest;
use App\Http\Requests\UpdateAccountsRequest;
use App\Models\Accounts;
use App\Models\AccountType;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use App\Enums;
use App\Enums\AccountTypes;
use App\Enums\BalanceStatus;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Accounts::orderby('id', 'DESC')->paginate(10);

        foreach ($data as $item) {

            $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

            $item['parent_name'] = Accounts::where(['id' => $item->parent_account_number])->value('name');

            $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

            if ($item->updated_by > 0 && $item->updated_by != null) {
                $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
            }

            if ($item->parent_account_number != null && $item->parent_account_number > 0) {
                $item['parent_account_name'] = Accounts::where(['account_number' => $item->parent_account_number])->value('name');
            }
        }

        return view('admin.accounts.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $account_type = AccountType::select('id', 'name')->where(['active' => 1, 'relatedinternalaccounts' => 0])->get();
        $accounts =  Accounts::where(['parent_account_number' => 0, 'com_code' => $com_code])->get();
        return view('admin.accounts.create', compact('account_type', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountsRequest $request)
    {
        $account_number = Accounts::max('account_number');
        $customer_code = Customer::max('customer_code');
        $exist = Accounts::where(['name' => $request->name])->exists();


        if ($exist) {
            return redirect()->back()->with('error', 'الاسم موجود بالفعل')->withInput();
        }

        $data['account_number'] = ($account_number ?? 0) + 1;

        $customer_data['customer_code'] = $customer_code ? $customer_code + 1 : 1;

        $data['is_parent'] = $request->parent_account_number == 0 ? 1 : 0;

        $data['start_balance'] = 0;

        if (($request->start_balance_status == BalanceStatus::Creditor->value || $request->start_balance_status == BalanceStatus::Debtor->value) && $request->start_balance == 0) {
            return redirect()->back()->with('error', 'ادخل قيمه صحيحه لرصيد الحساب')->withInput();
        }

        if ($request->start_balance_status == BalanceStatus::Creditor->value && $request->start_balance > 0) {
            $data['start_balance'] = $request->start_balance * (100);
        }

        if ($request->start_balance_status == BalanceStatus::Creditor->value && $request->start_balance < 0) {
            $data['start_balance'] = $request->start_balance * (-100);
        }

        if ($request->start_balance_status ==  BalanceStatus::Debtor->value && $request->start_balance < 0) {
            $data['start_balance'] = $request->start_balance * (100);
        }
        if ($request->start_balance_status == BalanceStatus::Debtor->value && $request->start_balance > 0) {
            $data['start_balance'] = $request->start_balance * (-100);
        }


        $data = [
            'name' => $request->name,
            'parent_account_number' => $request->parent_account_number,
            'account_type' => $request->account_type,
            'com_code' => auth()->user()->com_code,
            'added_by' => auth()->id(),
            'date' => date('Y-m-d'),
            'notes' => $request->notes,
            'is_archived' => $request->is_archived,
            'start_balance_status' => $request->start_balance_status,
            'other_table_fk' => $customer_data['customer_code'],
            'current_balance' => $data['start_balance'],
        ];

        Accounts::create($data);

        return redirect()->route('accounts.index');
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
        $data = Accounts::find($id);
        $com_code = auth()->user()->com_code;
        $account_type = AccountType::select('name')->where(['id' => $data['account_type']])->first();
        $data->parentAccountName =  Accounts::where(['account_number' => $data->parent_account_number, 'com_code' => $com_code])->value('name');
        return view('admin.accounts.edit', compact('data', 'account_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountsRequest $request, $id)
    {
        $data = Accounts::find($id);
        $exist = Accounts::where(['name' => $request->name])->where('id', '!=', $id)->exists();

        if ($exist) {
            return redirect()->back()->with('error', 'الاسم موجود بالفعل')->withInput();
        }

        $data['is_parent'] = $request->parent_account_number == 0 ? 1 : 1;

        $data['name'] = $request->name;
        $data['parent_account_number'] = $request->parent_account_number;
        $data['updated_by'] = auth()->user()->id;
        $data['notes'] = $request->notes;
        $data['is_archived'] = $request->is_archived;
        $data->save();

        $active = !$request->is_archived;

        if ($data['account_type'] == AccountTypes::Customer->value) {

            $customer_data = Customer::where(['account_number' => $data['account_number'], 'com_code' => $data['com_code']])->first();

            $customer_data['name'] = $request->name;
            $customer_data['updated_by'] = auth()->user()->id;
            $customer_data['notes'] = $request->notes;
            $customer_data['active'] = $active;
            $customer_data->save();
        }

        if ($data['account_type'] == AccountTypes::Supplier->value) {

            $supplier_data = Suppliers::where(['account_number' => $data['account_number'], 'com_code' => $data['com_code']])->first();

            $supplier_data['name'] = $request->name;
            $supplier_data['updated_by'] = auth()->user()->id;
            $supplier_data['notes'] = $request->notes;
            $supplier_data['active'] = $active;
            $supplier_data->save();
        }

        if ($data['account_type'] == AccountTypes::Delegate->value) {

            $delegate_data = Delegate::where(['account_number' => $data['account_number'], 'com_code' => $data['com_code']])->first();

            $delegate_data['name'] = $request->name;
            $delegate_data['updated_by'] = auth()->user()->id;
            $delegate_data['notes'] = $request->notes;
            $delegate_data['active'] = $active;
            $delegate_data->save();
        }

        return redirect()->route('accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Accounts::find($id);

        if ($data['account_type'] == AccountTypes::Customer->value) {

            $customer_id = Customer::select('id')->where([
                'account_number' => $data['account_number'],
                'com_code' => $data['com_code'],
                'customer_code' => $data['other_table_fk'],
            ])->value('id');
            Customer::destroy($customer_id);
        }
        if ($data['account_type'] == AccountTypes::Supplier->value) {

            $supplier_id = Suppliers::select('id')->where([
                'account_number' => $data['account_number'],
                'com_code' => $data['com_code'],
                'supplier_code' => $data['other_table_fk'],
            ])->value('id');
            Suppliers::destroy($supplier_id);
        }

        if ($data['account_type'] == AccountTypes::Delegate->value) {

            $delegate_id = Delegate::select('id')->where([
                'account_number' => $data['account_number'],
                'com_code' => $data['com_code'],
                'delegate_code' => $data['other_table_fk'],
            ])->value('id');
            Delegate::destroy($delegate_id);
        }

        Accounts::destroy($id);
        return redirect()->route('accounts.index');
    }

    public function filter(Request $request)
    {
        $com_code = auth()->user()->com_code;
        $parentOrNo = $request->type;

        $data = Accounts::orderby('id', 'DESC')->paginate(5);

        if ($parentOrNo == 1 || $parentOrNo == 0) {
            $data = Accounts::where(['is_parent' => $request->type, 'com_code' => $com_code])->paginate(5);
        }
        foreach ($data as $item) {

            $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

            $item['parent_name'] = Accounts::where(['id' => $item->parent_account_number])->value('name');

            $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

            if ($item->updated_by > 0 && $item->updated_by != null) {
                $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
            }

            if ($item->parent_account_number != null && $item->parent_account_number > 0) {
                $item['parent_account_name'] = Accounts::where(['account_number' => $item->parent_account_number])->value('name');
            }
        }
        return view('admin.accounts.index', compact('data', 'parentOrNo'));
    }
}