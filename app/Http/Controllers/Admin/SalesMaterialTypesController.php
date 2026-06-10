<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesMaterialType;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\SalesMaterialRequest;

class SalesMaterialTypesController extends Controller
{
    public function index()
    {
        $data = SalesMaterialType::orderby('id', 'DESC')->paginate(5);
        if (!empty($data)) {
            foreach ($data as $item) {
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.sales_material.index', ['data' => $data]);
    }


    public function create()
    {
        return view('admin.sales_material.create');
    }

    public function store(SalesMaterialRequest $request)
    {
        $com_code = auth()->user()->com_code;
        $checkExists = SalesMaterialType::where(['name' => $request->name, 'com_code' => $com_code])->exists();
        if ($checkExists) {
            return redirect()->back()->with(['error' => 'هذه الخزنه موجوده بالفعل']);
        } else {
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['active'] = $request->active;
            $data['added_by'] = auth()->user()->id;
            $data['com_code'] = $com_code;
            $data['date'] = date("Y-m-d");
            SalesMaterialType::create($data);
            return redirect()->route('admin.sales_material.index');
        }
    }

    public function edit($id)
    {
        $data = SalesMaterialType::find($id);
        if (!empty($data)) {
            return view('admin.sales_material.edit', compact('data'));
        }
        return view('admin.sales_material.index');
    }

    public function update($id, SalesMaterialRequest $request)
    {
        $treasury = SalesMaterialType::findOrFail($id);
        $com_code = auth()->user()->com_code;

        $nameExists = SalesMaterialType::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->exists();

        if ($nameExists) {
            return redirect()->back()
                ->with('error', 'اسم الفئه موجود بالفعل')
                ->withInput();
        }

        $treasury->update([
            'name'                => $request->name,
            'active'              => $request->active,
            'updated_by'          => auth()->user()->id,
            'date'                => date("Y-m-d"),
        ]);

        return redirect()
            ->route('admin.sales_material.index');
    }

    public function delete($id)
    {
        SalesMaterialType::destroy($id);

        return redirect()->back();
    }
}