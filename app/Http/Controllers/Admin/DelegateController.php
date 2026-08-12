<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        if (!empty($data)) {

            foreach ($data as $item) {

                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

                $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
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
    public function store(Request $request)
    {
        $delegate_code = Delegate::max('delegate_code');
        $account_number = Accounts::max('account_number');
        $exist = Delegate::where(['name' => $request->name])->exists();

        if ($exist) {
            return redirect()->back()->with('error', 'الاسم موجود بالفعل')->withInput();
        }

        if ($delegate_code == null) {
            $data['delegate_code'] = 1;
        } else {
            $data['delegate_code'] = $delegate_code + 1;
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
                $data['start_balance'] = $request->start_balance * (100);
            } elseif ($request->start_balance == 0) {
                return redirect()->back()->with('error', 'ادخل قيمه صحيحه لرصيد الحساب')->withInput();
            } else {
                $data['start_balance'] = $request->start_balance * (-100);
            }
        } elseif ($request->start_balance_status == 2) {
            if ($request->start_balance < 0) {
                $data['start_balance'] = $request->start_balance * (100);
            } elseif ($request->start_balance == 0) {
                return redirect()->back()->with('error', 'ادخل قيمه صحيحه لرصيد الحساب')->withInput();
            } else {
                $data['start_balance'] = $request->start_balance * (-100);
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
        $data['current_balance'] = $data['start_balance'];
        $data['commission_type'] = 0;
        $data['percent_Wholesale_commission'] = 0;
        $data['percent_half_wholesale_commission'] =0;
        $data['percent_retail_commission'] = 0;
        $data['percent_collect_commission'] = 0;


        $flage = Delegate::create($data);


        if ($flage) {

            if ($request->active == 1) {
                $data['is_archived'] = 0;
            } else {
                $data['is_archived'] = 1;
            }

            $data['account_type'] = 4;
            $data['is_parent'] = 0;
            $data['other_table_fk'] =  $data['delegate_code'];
            $data['parent_account_number'] = AdminPanalSettings::select('delegate_parent_account_number')->where('com_code', $data['com_code'])->value('delegate_parent_account_number');
            Accounts::create($data);
        }

        return redirect()->route('delegate.index');
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
    public function update(Request $request, $id)
    {

        $data = Delegate::find($id);
        $exists = Delegate::where(['name' => $request->name])->where('id', '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'هذا الاسم موجود بالفعل')->withInput();
        }

        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['notes'] = $request->notes;
        $data['active'] = $request->active;

        $flage = $data->save();

        if ($flage) {

            if($request->active == 0)
            {
                $is_archived = 1;
            }
            else{
                $is_archived = 0;
            }

            Accounts::where(['other_table_fk'=> $data->delegate_code ,'account_number'=>$data['account_number'] ,'com_code'=>$data['com_code']])
                ->update([
                    'name' => $request->name,
                    'is_archived' =>  $is_archived,
                    'notes' => $request->notes,
                    'updated_by' => auth()->user()->id,
                ]);
        }

        return redirect()->route('delegate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $code = Delegate::select('delegate_code','account_number','com_code')->where(['id' => $id])->first();
        $id_account = Accounts::select('id')->where(['other_table_fk'=>$code['delegate_code'] , 'account_type'=>4,'account_number'=>$code['account_number'], 'com_code'=>$code['com_code'] ])->value('id');
        Delegate::destroy($id);
        Accounts::destroy($id_account);
        return redirect()->route('delegate.index');
    }
}