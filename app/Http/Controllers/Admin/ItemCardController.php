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
        $categories = Category::select('id','name')->get();
        $data = ItemCard::orderby('id', 'DESC')->paginate(5);
        if (!empty($data)) {
            foreach ($data as $item) {

                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

                $item['category_name'] = Category::where(['id' => $item->categories_id])->value('name');

                $item['parent_name'] = ItemCard::where(['id' => $item->parent_id])->value('name');

                $item['unit_name'] = Unit::where(['id' => $item->parent_unit_id])->value('name');

                $item['retail_unit_name'] = Unit::where(['id' => $item->retail_unit_id])->value('name');


                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }
            }
        }
        return view('admin.itemcard.index', compact('data', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $categories = Category::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();
        $units = Unit::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1, 'is_master' => 1])->get();
        $retail_units = Unit::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1, 'is_master' => 0])->get();
        $items = ItemCard::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();
        return view('admin.itemcard.create', compact('categories', 'units', 'retail_units', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemCardRequest $request)
    {
        $com_code = auth()->user()->com_code;

        $item_code = ItemCard::select('item_code')->where(['com_code' => $com_code])->orderby('id', 'DESC')->first();
        // check for item code
        if (!empty($item_code)) {
            $data['item_code'] = $item_code->item_code + 1;
        } else {
            $data['item_code'] = 1;
        }

        //check for barcode and if not exist will make it automaticlly
        if (!empty($request->barcode)) {
            $exists = ItemCard::where(['barcode' => $request->barcode, 'com_code' => $com_code])->exists();
            if ($exists) {
                return redirect()->back()->with('error', 'هذا الباركود موجود بالفعل')->withInput();
            }
            $data['barcode'] = $request->barcode;
        } else {
            $data['barcode'] = "item" . $data['item_code'];
        }

        //check for name to make sure each company have only 1 and the item not doublicated
        $nameexists = ItemCard::where(['name' => $request->name, 'com_code' => $com_code])->exists();
        if ($nameexists) {
            return redirect()->back()->with('error', 'هذا الصنف موجود بالفعل')->withInput();
        }


        //check if there is photo
        if ($request->hasFile('photo')) {

            $request->validate([
                'photo' => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);

            // upload new photo
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/admin/uploads'), $filename);

            $data['photo'] = $filename;
        }

        //for creation
        $data['name'] = $request->name;
        $data['item_type'] = $request->item_type;
        $data['categories_id'] = $request->category_id;


        $data['parent_id'] = $request->parent_id;
        $data['parent_unit_id'] = $request->unit_parent_id;
        $data['Wholesale_price'] = $request->Wholesale_price * 100;
        $data['half_Wholesale_price'] = $request->half_Wholesale_price * 100;
        $data['price'] = $request->price * 100;
        $data['cost_price'] = $request->cost_price * 100;



        $data['has_retail_unit'] = $request->has_retail_unit;

        if ($request->has_retail_unit == 1) {
            $data['retail_unit_id'] = $request->retail_units;
            $data['retail_unit_to_parent'] = $request->retail_unit_to_parent;
            $data['retail_Wholesale_price'] = $request->retail_Wholesale_price * 100;
            $data['retail_half_Wholesale_price'] = $request->retail_half_Wholesale_price * 100;
            $data['retail_price'] = $request->retail_price * 100;
            $data['retail_cost_price'] = $request->retail_cost_price * 100;
        }

        $data['has_fixed_price'] = $request->has_fixed_price;
        $data['active'] = $request->active;
        $data['added_by'] = auth()->user()->id;
        $data['date'] = date('Y-m-d');

        $data['com_code'] = $com_code;

        ItemCard::create($data);
        return redirect()->route('itemcard.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = ItemCard::find($id);

        $data['category'] = Category::select('name')->where(['id'=>$data->categories_id])->first();
        $data['units'] = Unit::select('name')->where(['id'=>$data->parent_unit_id])->first();
        $data['retail_units'] = Unit::select('id', 'name')->where(['id'=>$data->retail_unit_id])->first();
        $data['items'] = ItemCard::select('id', 'name')->where(['id'=>$data->id])->first();

        return view('admin.itemcard.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ItemCard::find($id);

        $com_code = auth()->user()->com_code;
        $categories = Category::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();
        $units = Unit::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1, 'is_master' => 1])->get();
        $retail_units = Unit::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1, 'is_master' => 0])->get();
        $items = ItemCard::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();


        return view('admin.itemcard.edit', compact('data', 'categories', 'units', 'retail_units', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemCardRequest $request, $id)
    {
        $data = ItemCard::find($id);

        $com_code = auth()->user()->com_code;
        //check for barcode and if not exist will make it automaticlly
        if (!empty($request->barcode)) {
            $exists = ItemCard::where(['barcode' => $request->barcode, 'com_code' => $com_code])->where('id', '!=', $id)->exists();
            if ($exists) {
                return redirect()->back()->with('error', 'هذا الباركود موجود بالفعل')->withInput();
            }
            $data['barcode'] = $request->barcode;
        } else {
            $data['barcode'] = "item" . $request['item_code'];
        }


        //check for name to make sure each company have only 1 and the item not doublicated
        $nameexists = ItemCard::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->exists();
        if ($nameexists) {
            return redirect()->back()->with('error', 'هذا الصنف موجود بالفعل')->withInput();
        }

        if ($request->delete_photo == '1') {

            if ($data->photo != null) {
                $oldPath = public_path('assets/admin/uploads/' . $data->photo);

                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $data['photo'] = null;
        }

        if ($request->hasFile('photo')) {

            $request->validate([
                'photo' => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($data->photo != null) {
                $oldPath = public_path('assets/admin/uploads/' . $data->photo);

                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // upload new photo
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/admin/uploads'), $filename);

            $data->photo = $filename;
        }


        $data['name'] = $request->name;
        $data['item_type'] = $request->item_type;
        $data['categories_id'] = $request->category_id;


        $data['parent_id'] = $request->parent_id;
        $data['parent_unit_id'] = $request->unit_parent_id;
        $data['Wholesale_price'] = $request->Wholesale_price;
        $data['half_Wholesale_price'] = $request->half_Wholesale_price;
        $data['price'] = $request->price;
        $data['cost_price'] = $request->cost_price;



        $data['has_retail_unit'] = $request->has_retail_unit;

        if ($request->has_retail_unit == 1) {
            $data['retail_unit_id'] = $request->retail_units;
            $data['retail_unit_to_parent'] = $request->retail_unit_to_parent;
            $data['retail_Wholesale_price'] = $request->retail_Wholesale_price;
            $data['retail_half_Wholesale_price'] = $request->retail_half_Wholesale_price;
            $data['retail_price'] = $request->retail_price;
            $data['retail_cost_price'] = $request->retail_cost_price;
        } else {
            $data['retail_unit_id'] = null;
            $data['retail_unit_to_parent'] = null;
            $data['retail_Wholesale_price'] = null;
            $data['retail_half_Wholesale_price'] = null;
            $data['retail_price'] = null;
            $data['retail_cost_price'] = null;
        }

        $data['has_fixed_price'] = $request->has_fixed_price;
        $data['active'] = $request->active;
        $data['updated_by'] = auth()->user()->id;
        $data['date'] = date('Y-m-d');


        $data->save();
        return redirect()->route('itemcard.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ItemCard::destroy($id);
        return redirect()->route('itemcard.index');
    }
}