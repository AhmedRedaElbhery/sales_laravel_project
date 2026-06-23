<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierCategoryRequest;
use App\Models\Admin;
use App\Models\SupplierCategory;
use Illuminate\Http\Request;

class SupplierCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $com_code = auth()->user()->com_code;
        $data = SupplierCategory::where(['com_code'=>$com_code])->orderby('id', 'DESC')->paginate(5);
        if (!empty($data)) {
            foreach ($data as $item) {
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.supplier_category.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supplier_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierCategoryRequest $request)
    {

        $com_code = auth()->user()->com_code;
        $checkExists = SupplierCategory::where(['name' => $request->name, 'com_code' => $com_code])->exists();
        if ($checkExists) {
            return redirect()->back()->with(['error' => 'هذه الفئه موجوده بالفعل'])->withInput();
        } else {
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['added_by'] = auth()->user()->id;
            $data['com_code'] = $com_code;
            $data['date'] = date("Y-m-d");
            SupplierCategory::create($data);
            return redirect()->route('suppliers.index');
        }
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
        $data = SupplierCategory::find($id);
        return view('admin.supplier_category.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierCategoryRequest $request, $id)
    {
        $treasury = SupplierCategory::findOrFail($id);
        $com_code = auth()->user()->com_code;

        $nameExists = SupplierCategory::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->exists();

        if ($nameExists) {
            return redirect()->back()
                ->with('error', 'اسم الفئه موجود بالفعل')
                ->withInput();
        }

        $treasury->update([
            'name'                => $request->name,
            'active'              => $request->active,
            'updated_by'          => auth()->user()->id,
        ]);

        return redirect()->route('suppliers.index');
    }

    public function destroy($id)
    {
        SupplierCategory::destroy($id);

        return redirect()->route('suppliers.index');
    }
}