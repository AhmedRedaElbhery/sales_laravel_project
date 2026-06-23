<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountsRequest;
use App\Http\Requests\UpdateAccountsRequest;
use App\Models\Accounts;
use App\Models\AccountType;
use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Accounts::orderby('id', 'DESC')->paginate(5);

        if (!empty($data)) {

            foreach ($data as $item) {

                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

                $item['parent_name'] = Accounts::where(['id' => $item->parent_account_number])->value('name');

                $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }

                if ($item->parent_account_number != null && $item->parent_account_number > 0) {
                    $item['parent_account_name'] = Accounts::where(['id' => $item->parent_account_number])->value('name');
                } else {
                    $item['parent_account_name'] = "لا يوجد";
                }
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

        if ($account_number == null) {
            $data['account_number'] = 1;
        } else {
            $data['account_number'] = $account_number + 1;
        }

        if ($customer_code == null) {
            $customer_data['customer_code'] = 1;
        } else {
            $customer_data['customer_code'] = $customer_code + 1;
        }

        if ($request->parent_account_number == 0) {
            $data['is_parent'] = 1;
        } else {
            $data['is_parent'] = 0;
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
        $data['parent_account_number'] = $request->parent_account_number;
        $data['account_type'] = $request->account_type;
        $data['com_code'] = auth()->user()->com_code;
        $data['added_by'] = auth()->user()->id;
        $data['date'] = date('Y-m-d');
        $data['notes'] = $request->notes;
        $data['is_archived'] = $request->is_archived;
        $data['start_balance_status'] = $request->start_balance_status;
        $data['other_table_fk'] = $customer_data['customer_code'];

        //dd($request->parent_account_id);
        $flage = Accounts::create($data);
        if ($flage) {

            if ($request->account_type == 3) {

                $customer_data['name'] = $request->name;
                $customer_data['com_code'] = auth()->user()->com_code;
                $customer_data['added_by'] = auth()->user()->id;
                $customer_data['date'] = date('Y-m-d');
                $customer_data['notes'] = $request->notes;
                $customer_data['active'] = $request->is_archived;
                $customer_data['current_balance'] = 0;
                $customer_data['start_balance'] = $data['start_balance'];
                $customer_data['account_number'] = $data['account_number'];
                $customer_data['start_balance_status'] = $request->start_balance_status;
                Customer::create($customer_data);
            }
        }

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
        $account_type = AccountType::select('name')->where(['id' =>$data['account_type']])->first();
        $accounts =  Accounts::where(['parent_account_number' => 0, 'com_code' => $com_code])->get();
        return view('admin.accounts.edit', compact('data', 'account_type', 'accounts'));
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

        if ($request->parent_account_number == 0) {
            $data['is_parent'] = 1;
        } else {
            $data['is_parent'] = 0;
        }

        $data['name'] = $request->name;
        $data['parent_account_number'] = $request->parent_account_number;
        $data['updated_by'] = auth()->user()->id;
        $data['notes'] = $request->notes;
        $data['is_archived'] = $request->is_archived;

        $flage = $data->save();
        if ($flage) {
            if ($data['account_type'] == 3) {

                $customer_data = Customer::where(['account_number' => $data['account_number'], 'com_code' => $data['com_code']])->first();

                $customer_data['name'] = $request->name;
                $customer_data['updated_by'] = auth()->user()->id;
                $customer_data['notes'] = $request->notes;
                $customer_data['active'] = $request->is_archived;
                $customer_data->save();
            }
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

        if ($data['account_type'] == 3) {

            $customer_id = Customer::select('id')->where([
                'account_number' => $data['account_number'],
                'com_code' => $data['com_code'],
                'customer_code' => $data['other_table_fk'],
            ])->first();
            $customer_id = $customer_id['id'];
            Customer::destroy($customer_id);
        }
        Accounts::destroy($id);
        return redirect()->route('accounts.index');
    }

    public function filter(Request $request)
    {
        $com_code = auth()->user()->com_code;
        $type = $request->type;

        if ($request->type == 1 || $request->type == 0) {
            $data = Accounts::where(['is_parent' => $request->type, 'com_code' => $com_code])->paginate(5);
        } else {
            $data = Accounts::orderby('id', 'DESC')->paginate(5);
        }
        foreach ($data as $item) {

            $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

            $item['parent_name'] = Accounts::where(['id' => $item->parent_account_number])->value('name');

            $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

            if ($item->updated_by > 0 && $item->updated_by != null) {
                $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
            }

            if ($item->parent_account_number != null && $item->parent_account_number > 0) {
                $item['parent_account_name'] = Accounts::where(['id' => $item->parent_account_number])->value('name');
            } else {
                $item['parent_account_name'] = "لا يوجد";
            }
        }
        return view('admin.accounts.index', compact('data', 'type'));
    }
}