<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BalanceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\DelegateRequest;
use App\Http\Requests\UpdateDelegateRequest;
use App\Models\Accounts;
use App\Models\AccountType;
use App\Models\Admin;
use App\Models\AdminPanalSettings;
use App\Models\Delegate;
use Illuminate\Http\Request;

class DelegateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = Delegate::where(['com_code' => $com_code])->orderby('id', 'DESC')->paginate(5);

        foreach ($data as $item) {

            $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

            $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

            if ($item->updated_by > 0 && $item->updated_by != null) {
                $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
            }
        }

        return view('admin.delegates.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.delegates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DelegateRequest $request)
    {
        $delegate_code = Delegate::max('delegate_code');
        $account_number = Accounts::max('account_number');
        $exist = Delegate::where(['name' => $request->name])->exists();

        if ($exist) {
            return redirect()->back()->with('error', 'this name already exist')->withInput();
        }

        $data['delegate_code'] = $delegate_code ? $delegate_code + 1 : 1;

        $data['account_number'] = ($account_number ?? 0) + 1;


        $data['address'] = $request->address;
        $data['start_balance'] = 0;

        if (($request->start_balance_status == 1 || $request->start_balance_status == 2) && $request->start_balance == 0) {
            return redirect()->back()->with('error', 'enter valid numbers')->withInput();
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



        $data = [
            'name' => $request->name,
            'com_code' => auth()->user()->com_code,
            'added_by' => auth()->id(),
            'date' => now()->toDateString(),
            'notes' => $request->notes,
            'active' => $request->active,
            'current_balance' => 0,
            'start_balance_status' => $request->start_balance_status,
            'commission_type' => $request->commission_type,
            'percent_Wholesale_commission' => $request->percent_Wholesale_commission,
            'percent_half_wholesale_commission' => $request->percent_half_wholesale_commission,
            'percent_retail_commission' => $request->percent_retail_commission,
            'percent_collect_commission' => $request->percent_collect_commission,
        ];

        Delegate::create($data);

        $data['is_archived'] = !$request->active;


        $data['account_type'] = 4;
        $data['is_parent'] = 0;
        $data['other_table_fk'] =  $data['delegate_code'];
        $data['parent_account_number'] = AdminPanalSettings::select('delegate_parent_account_number')->where('com_code', $data['com_code'])->value('delegate_parent_account_number');
        Accounts::create($data);

        return redirect()->route('delegate.index')->with('success','added successfully');
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
        $data = Delegate::find($id);
        return view('admin.delegates.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDelegateRequest $request, $id)
    {

        $data = Delegate::find($id);
        $exists = Delegate::where(['name' => $request->name])->where('id', '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'this name already exist')->withInput();
        }

        $data->update([
            'commission_type' => $request->commission_type,
            'percent_Wholesale_commission' => $request->percent_Wholesale_commission,
            'percent_half_wholesale_commission' => $request->percent_half_wholesale_commission,
            'percent_retail_commission' => $request->percent_retail_commission,
            'percent_collect_commission' => $request->percent_collect_commission,
            'name' => $request->name,
            'address' => $request->address,
            'notes' => $request->notes,
            'active' => $request->active,
        ]);


        $is_archived = !$request->active;

        Accounts::where(['other_table_fk' => $data->delegate_code, 'account_number' => $data['account_number'], 'com_code' => $data['com_code']])
            ->update([
                'name' => $request->name,
                'is_archived' =>  $is_archived,
                'notes' => $request->notes,
                'updated_by' => auth()->user()->id,
            ]);


        return redirect()->route('delegate.index')->with('success','updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $code = Delegate::select('delegate_code', 'account_number', 'com_code')->where(['id' => $id])->first();
        $id_account = Accounts::select('id')->where(['other_table_fk' => $code['delegate_code'], 'account_type' => 4, 'account_number' => $code['account_number'], 'com_code' => $code['com_code']])->value('id');
        Delegate::destroy($id);
        Accounts::destroy($id_account);
        return redirect()->route('delegate.index')->with('success','deleted successfully');
    }
}