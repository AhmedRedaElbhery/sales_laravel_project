<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TreasuriesRequest;
use App\Http\Requests\TreasuriesBranchRequest;
use App\Models\Treasuries;
use App\Models\TreasuryDelivery;
use App\Models\Admin;

class TreasuriesController extends Controller
{
    public function index()
    {
        $data = Treasuries::select()->orderby('id', 'DESC')->paginate(5);
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

    public function edit($id)
    {
        $data = Treasuries::find($id);
        if (!empty($data)) {
            return view('admin.treasuries.edit', compact('data'));
        }
        return view('admin.treasuries.index');
    }

    public function update($id, TreasuriesRequest $request)
    {
        $treasury = Treasuries::findOrFail($id);
        $com_code = auth()->user()->com_code;

        $nameExists = Treasuries::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->exists();

        if ($nameExists) {
            return redirect()->back()
                ->with('error', 'اسم الخزنة موجود بالفعل')
                ->withInput();
        }

        if ($request->is_master == 1) {
            $masterExists = Treasuries::where(['is_master' => 1, 'com_code' => $com_code])->where('id', '!=', $id)->exists();

            if ($masterExists) {
                return redirect()->back()
                    ->with('error', 'يوجد خزنة رئيسية بالفعل لا يمكن إضافة أكثر من خزنة رئيسية')
                    ->withInput();
            }
        }

        $treasury->update([
            'name'                => $request->name,
            'is_master'           => $request->is_master,
            'last_isal_exchange'  => $request->last_isal_exchange,
            'last_isal_collect'   => $request->last_isal_collect,
            'active'              => $request->active,
            'updated_by'          => auth()->user()->id,
            'updated_at'          => date("Y-m-d H:i:s"),
        ]);

        return redirect()
            ->route('admin.treasuries.index');
    }

    public function details($id)
    {
        $com_code = auth()->user()->id;
        $data = Treasuries::find($id);
        if (!empty($data)) {
            $treasuries_delivary = TreasuryDelivery::select()->where(['treasuries_id' => $id])->orderby('id', 'DESC')->get();

            $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');

            if ($data['updated_by'] != null && $data['updated_by'] > 0) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }

            foreach ($treasuries_delivary as $item) {
                $item['name'] = Treasuries::where(['id' => $item->treasuries_can_delivery_id])->value('name');
                //dd( $item['name'] );
                $item['added_by_admin'] = Admin::where(['id' => $item->added_by])->value('name');
            }

            return view('admin.treasuries.details', compact('data', 'treasuries_delivary'));
        }
        return redirect()->route('admin.treasuries.index');
    }

    public function delete($id)
    {
        TreasuryDelivery::destroy($id);

        return redirect()->back();
    }


    public function add_treasuries_branch($id)
    {
        $com_code = auth()->user()->com_code;
        $data = Treasuries::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1, 'is_master' => 0])->get();
        if (empty($data)) {
            return redirect()->route('admin.treasuries.index');
        }
        return view('admin.treasuries.create_treasuries_branch', compact('id', 'data'));
    }

    public function store_treasuries_branch(TreasuriesBranchRequest $request, $id)
    {
        $com_code = auth()->user()->com_code;
        $treasury = Treasuries::find($id);
        $branch = Treasuries::find($request->treasury_name);
        $exist = TreasuryDelivery::where([
            'treasuries_id' => $id,
            'treasuries_can_delivery_id' => $request->treasury_name,
            'com_code'=>$com_code
        ])->first();

        if (!empty($treasury) && !empty($branch) && $exist == NULL) {
            $data['treasuries_id'] = $id;
            $data['treasuries_can_delivery_id'] = $request->treasury_name;
            $data['com_code'] = $com_code;
            $data['added_by'] = auth()->user()->id;
            TreasuryDelivery::create($data);
            return redirect()->route('admin.treasuries.details', $id);
        } else {
            return redirect()->route('admin.treasuries.details', $id);
        }
    }
}