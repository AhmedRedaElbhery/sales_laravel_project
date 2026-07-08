<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionsRequest;
use App\Models\Accounts;
use App\Models\Admin;
use App\Models\AdminShifts;
use App\Models\MoveType;
use App\Models\Treasuries;
use App\Models\TreasuriesTransaction;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;

        $data = TreasuriesTransaction::where(['com_code'=>$com_code])->orderby('id', 'DESC')->paginate(5);

        if (!empty($data)) {
            foreach ($data as $item) {
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
            }
        }

        $exist = AdminShifts::where(['com_code'=>$com_code , 'admin_id'=>auth()->user()->id , 'is_finished'=> 0])->whereNull('end_shift')->first();
        if($exist != null)
        {
            $exist->treasuries_name = Treasuries::where(['id'=>$exist->treasuries_id])->value('name');
            $exist->total = Treasuries::where(['id'=>$exist->treasuries_id])->value('name');
            $treasuries_balance = TreasuriesTransaction::where(['com_code'=>$com_code , 'treasuries_id'=>$exist->treasuries_id , 'shift_id'=>$exist->id])->sum('money');
        }


        $accounts = Accounts::select('name','account_number')->where(['com_code'=>$com_code , 'is_archived'=>0,'is_parent'=>0])->get();
        $move_types = MoveType::select('name','id')->where(['active'=>1 , 'in_screen'=>1 ,'is_private_internal'=>0])->get();


        return view('admin.collect_transaction.index', compact('data','exist','accounts','treasuries_balance','move_types'));
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
        dd('test');
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