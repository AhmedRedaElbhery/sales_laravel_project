<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoresRequest;

class StoresController extends Controller
{
    public function index()
    {
        $data = Store::orderby('id', 'DESC')->paginate(5);
        if (!empty($data)) {
            foreach ($data as $item) {
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.stores.index', ['data' => $data]);
    }


    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(StoresRequest $request)
    {
        $com_code = auth()->user()->com_code;
        $checkExists = Store::where(['name' => $request->name, 'com_code' => $com_code])->exists();
        if ($checkExists) {
            return redirect()->back()->with(['error' => 'هذا المخزن موجود بالفعل']);
        } else {
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['address'] = $request->address;
            $data['phone'] = $request->phone;
            $data['added_by'] = auth()->user()->id;
            $data['com_code'] = $com_code;
            $data['date'] = date("Y-m-d");
            Store::create($data);
            return redirect()->route('admin.store.index');
        }
    }

    public function edit($id)
    {
        $data = Store::find($id);
        if(!empty($data))
        {
            return view('admin.stores.edit',compact('data'));
        }
        return redirect()->route('admin.store.index');
    }

    public function update($id, StoresRequest $request)
    {
        $data = Store::findOrFail($id);
        $com_code = auth()->user()->com_code;
        $exist = Store::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id', '!=', $id)->exists();

        if($exist)
        {
           return redirect()->back()->with('error', 'هذا المخزن موجود بالفعل')
           ->withInput();
        }

        $data->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'active' => $request->active,
            'updated_by' => auth()->user()->id,
        ]);
        return redirect()->route('admin.store.index');
    }

    public function delete($id)
    {
        Store::destroy($id);

        return redirect()->back();
    }

}