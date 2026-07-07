<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminShiftsRequest;
use App\Models\Admin;
use App\Models\AdminShifts;
use App\Models\AdminTreasuries;
use App\Models\Treasuries;
use Illuminate\Http\Request;

class AdminShiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;

        $data = AdminShifts::where(['com_code'=>$com_code])->orderby('id', 'DESC')->paginate(5);

        if (!empty($data)) {
            foreach ($data as $item) {
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                $item['treasuries_name'] = Treasuries::where(['id' => $item->treasuries_id])->value('name');
                $item['admin_name'] = Admin::where(['id' => $item->admin_id])->value('name');
                $item['name'] = Treasuries::where(['id'=>$item->treasuries_id])->value('name');
            }
        }

        return view('admin.admin_shifts.index', ['data' => $data]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $treasuries = AdminTreasuries::select('treasuries_id')->where(['com_code' => $com_code, 'active' => 1,'admin_id'=>auth()->user()->id])->get();
        foreach($treasuries as $item)
        {
            $item['name'] = Treasuries::where(['id'=>$item->treasuries_id])->value('name');
            $exists = AdminShifts::where(['treasuries_id'=>$item->treasuries_id , 'com_code'=>$com_code, 'is_finished'=>0])->whereNull('end_shift')->exists();
            if($exists)
            {
                $item->status = false;
            }
            else{
                $item->status = true;
            }
        }
        return view('admin.admin_shifts.create', compact('treasuries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminShiftsRequest $request)
    {
        $com_code = auth()->user()->com_code;
        $exists = AdminShifts::where(['admin_id'=>auth()->user()->id ,'com_code'=>$com_code])->whereNull('end_shift')->exists();

        if($exists)
        {
            return redirect()->route('admin_shifts.index')->with('error','يوجد شفت مفتوح بالفعل');
        }

        $data['admin_id'] = auth()->user()->id;
        $data['treasuries_id'] = $request->treasuries_id;
        $data['start_shift'] = now();
        $data['added_by'] = auth()->user()->id;
        $data['com_code'] = auth()->user()->com_code;
        $data['date'] = date('Y-m-d');

        AdminShifts::create($data);

        return redirect()->route('admin_shifts.index');
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