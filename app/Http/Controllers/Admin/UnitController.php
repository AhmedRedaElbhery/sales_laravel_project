<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\unitsRequest;
use App\Models\Admin;
use App\Models\unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = unit::orderby('id', 'DESC')->paginate(5);

        if (!empty($data)) {
            foreach ($data as $item) {
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                if ($item->updated_at && $item->updated_at  != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.units.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(unitsRequest $request)
    {
        $com_code = auth()->user()->com_code;
        $exist = unit::where(['name' => $request->name, 'com_code' => $com_code])->exists();
        if (!$exist) {
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['is_master'] = $request->is_master;
            $data['added_by'] = auth()->user()->id;
            $data['com_code'] = $com_code;
            $data['date'] = date('Y-m-d');
            unit::create($data);
        }
        return redirect()->route('unit.index');
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
        $data = unit::find($id);
        if(!empty($data))
        {
            return view('admin.units.edit',compact('data'));
        }
        return redirect()->route('unit.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(unitsRequest $request, $id)
    {
        $data = unit::findOrFail($id);
        $com_code = auth()->user()->com_code;
        $exist = unit::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id', '!=', $id)->exists();

        if($exist)
        {
           return redirect()->back()->with('error', 'هذه الوحده موجوده بالفعل')
           ->withInput();
        }

        $data->update([
            'name' => $request->name,
            'is_master' => $request->is_master,
            'active' => $request->active,
            'updated_by' => auth()->user()->id,
        ]);
        return redirect()->route('unit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        unit::destroy($id);
        return redirect()->route('unit.index');
    }

    public function filter(Request $request)
    {
        $com_code = auth()->user()->com_code;
        $type = $request->type;

        if($request->type == 1 || $request->type == 0)
        {
            $data = unit::where(['is_master'=>$request->type , 'com_code'=>$com_code])->paginate(5);
        }
        else
        {
            $data = unit::orderby('id', 'DESC')->paginate(5);

        }
        return view('admin.units.index',compact('data','type'));
    }

}