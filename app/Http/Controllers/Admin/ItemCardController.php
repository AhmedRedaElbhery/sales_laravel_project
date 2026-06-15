<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCardRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\ItemCard;
use App\Models\Unit;
use Illuminate\Http\Request;

class ItemCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ItemCard::orderby('id', 'DESC')->paginate(5);
        if (!empty($data)) {
            foreach ($data as $item) {

                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

                $item['category_name'] = Category::where(['id' => $item->categories_id ])->value('name');

                $item['parent_name'] = ItemCard::where(['id' => $item->parent_id ])->value('name');

                $item['unit_name'] = Unit::where(['id' => $item->parent_unit_id ])->value('name');

                $item['retail_unit_name'] = Unit::where(['id' => $item->retail_unit_id ])->value('name');


                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.itemcard.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $categories = Category::select('id','name')->where(['com_code'=>$com_code ,'active'=>1 ])->get();
        $units = Unit::select('id','name')->where(['com_code'=>$com_code ,'active'=>1 ,'is_master'=>1 ])->get();
        $retail_units = Unit::select('id','name')->where(['com_code'=>$com_code ,'active'=>1 ,'is_master'=>0 ])->get();
        return view('admin.itemcard.create',compact('categories','units','retail_units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemCardRequest $request)
    {

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