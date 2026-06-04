<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TreasuriesRequest;
use App\Models\Treasuries;
use App\Models\Admin;

class TreasuriesController extends Controller
{
    public function index()
    {
        $data = Treasuries::select()->orderby('id', 'DESC')->paginate(10);
        if (!empty($data)) {
            foreach ($data as $item) {

                $item['added_by_admin'] = Admin::where('id', $item['added_by'])->value('name');

                if ($item['updated_by'] != null && $item['updated_by'] > 0) {
                    $item['updated_by_admin'] = Admin::where('id', $item['updated_by'])->value('name');
                }
            }
        }
        return view('admin.treasuries.index', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.treasuries.create');
    }

    public function store(TreasuriesRequest $request)
    {
        $com_code = auth()->user()->com_code;
        $checkExists = Treasuries::where(['name' => $request->name, 'com_code' => $com_code])->exists();
        if ($checkExists) {
            return redirect()->back()->with(['error' => 'هذه الخزنه موجوده بالفعل']);
        } else {
            if ($request->is_master == 1) {
                $checkExists = Treasuries::where(['is_master' => $request->is_master, 'com_code' => $com_code])->exists();
                if ($checkExists) {
                    return redirect()->back()->with('error', 'هناك خزنه رئيسيه موجوده بالفعل');
                } else {

                    $data['name'] = $request->name;
                    $data['is_master'] = $request->is_master;
                    $data['last_isal_exchange'] = $request->last_isal_exchange;
                    $data['last_isal_collect'] = $request->last_isal_collect;
                    $data['active'] = $request->active;
                    $data['added_by'] = auth()->user()->id;
                    $data['com_code'] = $com_code;
                    $data['date'] = date("Y-m-d");
                    Treasuries::create($data);
                    return redirect()->route('admin.treasuries.index');
                }
            } else {

                $data['name'] = $request->name;
                $data['is_master'] = $request->is_master;
                $data['last_isal_exchange'] = $request->last_isal_exchange;
                $data['last_isal_collect'] = $request->last_isal_collect;
                $data['active'] = $request->active;
                $data['added_by'] = auth()->user()->id;
                $data['com_code'] = $com_code;
                $data['date'] = date("Y-m-d");
                Treasuries::create($data);
                return redirect()->route('admin.treasuries.index');
            }
        }
    }
}