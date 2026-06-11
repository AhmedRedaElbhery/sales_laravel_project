<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::orderby('id','DESC')->paginate(5);
        if(!empty($data))
        {
            foreach($data as $item)
            {
                $item['added_by_admin'] = Admin::where(['id'=>$item->added_by])->value('name');
                if($item->updated_by && $item->updated_by != null )
                {
                    $item['updated_by_admin'] = Admin::where(['id'=>$item->updated_by])->value('name');
                }
            }
        }
        return view('admin.category.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        $com_code = auth()->user()->com_code;
        $exists = Category::where(['name'=>$request->name , 'com_code'=>$com_code])->exists();
        if(!$exists)
        {
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['com_code'] = $com_code;
            $data['date'] = date('Y-m-d');
            $data['added_by'] = auth()->user()->id;
            Category::create($data);
        }
        return redirect()->route('category.index');
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
        $data = Category::find($id);
        if(!empty($data))
        {
            return view('admin.category.edit',compact('data'));
        }
        return redirect()->route('category.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, $id)
    {
        $data = Category::findOrFail($id);
        $com_code = auth()->user()->com_code;
        $exists = Category::where(['name'=>$request->name , 'com_code'=>$com_code])->where('id', '!=', $id)->exists();
        if(!$exists)
        {
            $data['name'] = $request->name;
            $data['active'] = $request->active;
            $data['updated_by'] = auth()->user()->id;

            $data->save();

            return redirect()->route('category.index');
        }
        return redirect()->back()->with('error','هذا الصنف موجود بالفعل')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('category.index');
    }
}