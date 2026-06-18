<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\AccountType;
use App\Models\Admin;
use App\Models\Category;
use App\Models\ItemCard;
use App\Models\Unit;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Accounts::orderby('id', 'DESC')->paginate(5);

        if (!empty($data)) {

            foreach ($data as $item) {

                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');

                $item['parent_name'] = Accounts::where(['id' => $item->parent_account_number])->value('name');

                $item['type'] = AccountType::where(['id' => $item->account_type])->value('name');

                if ($item->updated_by > 0 && $item->updated_by != null) {
                    $item['updated_by_admin'] = Admin::where(['id' => $item->updated_by])->value('name');
                }

                if($item->parent_account_number != null && $item->parent_account_number > 0)
                {
                    $item['parent_account_name'] = Accounts::where(['id'=>$item->parent_account_number])->value('name');
                }
                else{
                    $item['parent_account_name'] = "لا يوجد";
                }
            }
        }
        return view('admin.accounts.index', compact('data'));
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