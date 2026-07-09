<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionsRequest;
use App\Models\Accounts;
use App\Models\AccountType;
use App\Models\Admin;
use App\Models\AdminShifts;
use App\Models\MoveType;
use App\Models\Treasuries;
use App\Models\TreasuriesTransaction;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;

        $data = TreasuriesTransaction::where(['com_code' => $com_code])->where('money_for_account', '>', 0)->orderby('id', 'DESC')->paginate(5);

        if (!empty($data)) {
            foreach ($data as $item) {
                $item->treasuries_name = Treasuries::where(['id' => $item->treasuries_id])->value('name');
                $item->admin_name = Admin::where(['com_code' => $com_code, 'id' => auth()->user()->id])->value('name');
                $item->move_type_name = MoveType::where(['id' => $item->move_type])->value('name');
            }
        }

        $exist = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'is_finished' => 0])->whereNull('end_shift')->first();
        if ($exist != null) {
            $exist->treasuries_name = Treasuries::where(['id' => $exist->treasuries_id])->value('name');
            $treasuries_balance = TreasuriesTransaction::where(['com_code' => $com_code, 'treasuries_id' => $exist->treasuries_id, 'shift_id' => $exist->id])->sum('money');
        }


        $accounts = Accounts::select('name', 'account_type' ,'account_number')->where(['com_code' => $com_code, 'is_archived' => 0, 'is_parent' => 0])->get();
        foreach ($accounts as $account) {
            $account->account_type_name = AccountType::where(['id' => $account->account_type])->value('name');
        }

        $move_types = MoveType::select('name', 'id')->where(['active' => 1, 'in_screen' => 0, 'is_private_internal' => 0])->get();


        return view('admin.exchange_transaction.index', compact('data', 'exist', 'accounts', 'treasuries_balance', 'move_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionsRequest $request)
    {
        if ($request->money  > $request->treasuries_balance) {
            return redirect()->back()->with(['error' => 'الرصيد لا يسمح']);
        }

        $com_code = auth()->user()->com_code;
        $isal_number = Treasuries::where(['com_code' => $com_code, 'id' => $request->treasuries_id])->max('last_isal_exchange');


        $shift_id = AdminShifts::where(['com_code' => $com_code, 'admin_id' => auth()->user()->id, 'treasuries_id' => $request->treasuries_id, 'is_finished' => 0])->whereNull('end_shift')->value('id');
        if ($shift_id != null) {
            $data['treasuries_id'] = $request->treasuries_id;
            $data['isal_number'] = $isal_number + 1;
            $data['move_type'] = $request->move_type;
            $data['account_number'] = $request->account_number;
            $data['money_for_account'] = $request->money * (100);
            $data['money'] = $request->money * 100;
            $data['byan'] = $request->byan;
            $data['added_by'] = auth()->user()->id;
            $data['date'] = $request->date;
            $data['com_code'] = $com_code;
            $data['shift_id'] = $shift_id;

            Treasuries::where([
                'id' => $request->treasuries_id,
                'com_code' => $com_code,
            ])->update([
                'last_isal_exchange' => $data['isal_number'],
            ]);

            TreasuriesTransaction::create($data);
            return redirect()->route('exchange_transaction.index');
        }


        return redirect()->back()->with(['error' => 'حدث خطا ما']);
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