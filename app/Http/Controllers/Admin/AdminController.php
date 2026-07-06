<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminTreasuries;
use App\Models\Treasuries;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;

        $data = Admin::where(['com_code'=>$com_code])->orderby('id', 'DESC')->paginate(5);

        if (!empty($data)) {
            foreach ($data as $item) {
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.admin_accounts.index', ['data' => $data]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $com_code = auth()->user()->com_code;
        $data = Admin::where(['id'=>$id , 'com_code'=>$com_code])->first();
        if (!empty($data))
        {
            $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');

            if ($data['updated_by'] != null && $data['updated_by'] > 0) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }


            $admin_treasuries = AdminTreasuries::where(['com_code'=>$com_code, 'admin_id'=>$id])->get();
            $treasuries = Treasuries::where(['com_code'=>$com_code, 'active'=>1])->get();
            if(!empty($admin_treasuries))
            {
                foreach($admin_treasuries as $item)
                {
                    $item->name = Treasuries::where(['id'=>$item->treasuries_id])->value('name');

                    if ($item['updated_by'] != null && $item['updated_by'] > 0) {
                        $item['updated_by_admin'] = Admin::where('id', $item['updated_by'])->value('name');
                    }

                }
            }

            return view('admin/admin_accounts.details',compact('data','admin_treasuries','treasuries'));

        }
        return redirect()->route('supplier_orders.index');
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

    public function add_treasuries(Request $request)
    {
        if($request->ajax())
        {
            $admin_id = $request->admin_id;
            $treasuries_id = $request->treasuries;

            $data['admin_id'] = $admin_id;
            $data['treasuries_id'] = $treasuries_id;
            $data['com_code'] = auth()->user()->com_code;
            $data['added_by'] = auth()->user()->id;
            $data['date'] = date('Y-m-d');


            AdminTreasuries::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Added successfully'
            ]);

        }
    }

    public function delete_treasuries($id)
    {
        AdminTreasuries::destroy($id);
        return redirect()->back();
    }


}