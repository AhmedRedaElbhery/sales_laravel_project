@extends('layouts.admin')

@section('title')
    {{ __('generalReturnOrders.title') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('contentheader')
    {{ __('generalReturnOrders.inventory_transactions') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('general_return_orders.index') }}">
        {{ __('generalReturnOrders.supplier_orders') }}
    </a>
@endsection

@section('contentheaderactive')
    {{ __('generalReturnOrders.show') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card-header">
                    <h3 class="card-title card_title_center">
                        {{ __('generalReturnOrders.invoice_data') }}
                    </h3>
                </div>

                <div class="card-body">
                    @if (isset($data))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <td class="width30">{{ __('generalReturnOrders.auto_invoice_code') }}</td>
                                <td>{{ $data['auto_serial'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('generalReturnOrders.invoice_date') }}</td>
                                <td>{{ $data['order_date'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('generalReturnOrders.supplier_name') }}</td>
                                <td>{{ $data['supplier_name'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('generalReturnOrders.invoice_type') }}</td>
                                <td>
                                    @if ($data['pill_type'] == 0)
                                        {{ __('generalReturnOrders.cash') }}
                                    @else
                                        {{ __('generalReturnOrders.credit') }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('generalReturnOrders.total_before_discount') }}</td>
                                <td>{{ $data['total_before_discount'] / 100 }}</td>
                            </tr>


                            @if ($data['descpunt_type'] != null)
                                <tr>
                                    <td class="width30">{{ __('generalReturnOrders.invoice_discount_type') }}</td>

                                    @if ($data['discount_type'] == 1)
                                        <td>
                                            {{ __('generalReturnOrders.percentage_discount') }}
                                            {{ $data['discount_percent'] }}
                                            {{ __('generalReturnOrders.discount_value') }}
                                            {{ $data['discount_value'] }}
                                        </td>
                                    @else
                                        <td>
                                            {{ __('generalReturnOrders.manual_discount') }}
                                            {{ __('generalReturnOrders.discount_value') }}
                                            {{ $data['discount_value'] }}
                                        </td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <td class="width30">{{ __('generalReturnOrders.invoice_discount_type') }}</td>
                                    <td>{{ __('generalReturnOrders.no_discount') }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td class="width30">{{ __('generalReturnOrders.taxes') }}</td>

                                @if ($data['tax_percent'] == 0 || $data['tax_percent'] == null)
                                    <td>{{ __('generalReturnOrders.no_tax') }}</td>
                                @else
                                    <td>
                                        {{ __('generalReturnOrders.tax_percentage') }}
                                        {{ $data['tax_percent'] }}
                                        {{ __('generalReturnOrders.discount_value') }}
                                        {{ $data['tax_value'] }}
                                    </td>
                                @endif
                            </tr>

                            <tr>
                                <td class="width30">{{ __('generalReturnOrders.total_after_discount') }}</td>
                                <td>{{ $data['total_cost'] / 100 }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('generalReturnOrders.store') }}</td>
                                <td>{{ $data['store_name'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('generalReturnOrders.added_at') }}</td>
                                <td>
                                    @if ($data['added_by'] > 0 && $data['added_by'] != null)
                                        @php
                                            $dt = new DateTime($data['created_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype =
                                                $newdatetime == 'AM'
                                                    ? __('suppliersOrders.morning')
                                                    : __('suppliersOrders.evening');
                                        @endphp

                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        {{ __('generalReturnOrders.added_by') }}
                                        {{ $data['added_by_admin'] }}
                                    @else
                                        {{ __('generalReturnOrders.no_data') }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('generalReturnOrders.updated_at') }}</td>
                                <td>
                                    @if ($data['updated_by'] > 0 && $data['updated_by'] != null)
                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype =
                                                $newdatetime == 'PM'
                                                    ? __('suppliersOrders.evening')
                                                    : __('suppliersOrders.morning');
                                        @endphp

                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        {{ __('generalReturnOrders.added_by') }}
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        {{ __('generalReturnOrders.no_data') }}
                                    @endif
                                </td>
                            </tr>



                            <tr>
                                <td>
                                    @if ($data['is_approved'] == 0)
                                        <a href="{{ route('general_return_orders.edit', $data->id) }}"
                                            class="btn btn-primary text-white">
                                            {{ __('generalReturnOrders.edit') }}
                                        </a>

                                        <button type="button" class="btn btn-success m-2" data-toggle="modal"
                                            data-target="#general_load_model_approve">
                                            {{ __('generalReturnOrders.approve') }}
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        @if ($data['is_approved'] == 0)
                            <button type="button" class="btn btn-info m-2" data-toggle="modal"
                                data-target="#general_add_item_model">
                                {{ __('generalReturnOrders.add_item_to_invoice') }}
                            </button>
                        @endif

                        <br>
                    @else
                        <div class="alert alert-warning">
                            {{ __('generalReturnOrders.no_data') }}
                        </div>
                    @endif



                    @if (isset($details) && count($details) > 0)
                        <div class="card-header">
                            <h3 class="card-title card_title_center">
                                {{ __('generalReturnOrders.invoice_items') }}
                            </h3>
                        </div>

                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>{{ __('generalReturnOrders.serial') }}</th>
                                    <th>{{ __('generalReturnOrders.item_name') }}</th>
                                    <th>{{ __('generalReturnOrders.item_unit') }}</th>
                                    <th>{{ __('generalReturnOrders.unit_price') }}</th>
                                    <th>{{ __('generalReturnOrders.quantity') }}</th>
                                    <th>{{ __('generalReturnOrders.total') }}</th>


                                    @if ($data['is_approved'] == 0)
                                        <th></th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($details as $bill_item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $bill_item->item_name }}</td>
                                        <td>{{ $bill_item->unit_name }}</td>
                                        <td>{{ $bill_item->unit_price / 100 }}</td>
                                        <td>{{ $bill_item->delivered_quantity * 1 }}</td>
                                        <td>{{ $bill_item->total_price / 100 }}</td>


                                        @if ($data['is_approved'] == 0)
                                            <td>
                                                <button type="button" class="btn btn-primary edititem" data-toggle="modal"
                                                    data-id="{{ $bill_item->id }}" data-target="#general_edit_item_model">
                                                    {{ __('generalReturnOrders.edit') }}
                                                </button>

                                                <form
                                                    action="{{ route('general_return_orders.destroy_details', $bill_item->id) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('{{ __('generalReturnOrders.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger">
                                                        {{ __('generalReturnOrders.delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">
                            {{ __('generalReturnOrders.no_data') }}
                        </div>
                    @endif



                </div>

            </div>
        </div>

        <div class="modal fade" id="general_add_item_model">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('generalReturnOrders.add_items') }}</h4>
                        <button type="button" class="close color-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                    <input type="hidden" id="ajax_getUnits_url" value="{{ route('general_return_orders.getUnits') }}">
                    <input type="hidden" id="ajax_addunits" value="{{ route('general_return_orders.addunits') }}">
                    <input type="hidden" id="ajax_edititem" value="{{ route('general_return_orders.edititem') }}">
                    <input type="hidden" id="ajax_updateitem" value="{{ route('general_return_orders.update_item') }}">
                    <input type="hidden" id="ajax_get_batchs" value="{{ route('general_return_orders.get_batchs') }}">
                    <input type="hidden" id="store_id" value="{{ $data->store_id}}">

                    <div class="modal-body" id="model_body" style="background-color: white !important; color: black;">
                        <div class="row">



                            <div class="col-4">
                                <div class="form-group">
                                    <label>{{ __('generalReturnOrders.item_data') }}</label>

                                    <select id="general_item_card_add" name="items" class="form-control select2">
                                        <option value="" selected disabled>
                                            {{ __('generalReturnOrders.select_item') }}
                                        </option>

                                        @if (isset($items))
                                            @foreach ($items as $item)
                                                <option data-type="{{ $item->item_type }}" value="{{ $item->item_code }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @error('items')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4 related_to_itemcard" style="display: none" id="unitsDiv">

                            </div>

                            <div class="col-4 batchs" style="display: none" id="batchs_div">

                            </div>

                            <div class="col-4 related_to_itemcard" style="display: none">
                                <div class="form-group">
                                    <label>{{ __('generalReturnOrders.return_quantity') }}</label>

                                    <input type="number" id="return_quantity" name="return_quantity" class="form-control"
                                        value="">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-info" id="addtobill">
                                        {{ __('generalReturnOrders.add_items_button') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                            {{ __('generalReturnOrders.close') }}
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


         <div class="modal fade" id="general_edit_item_model">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('generalReturnOrders.update_item') }}</h4>
                        <button type="button" class="close color-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                    <input type="hidden" id="ajax_getUnits_url" value="{{ route('general_return_orders.getUnits') }}">
                    <input type="hidden" id="ajax_addunits" value="{{ route('general_return_orders.addunits') }}">
                    <input type="hidden" id="ajax_edititem" value="{{ route('general_return_orders.edititem') }}">

                    <div class="modal-body" id="edit_item_model_body"
                        style="background-color: white !important; color: black;">

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                            {{ __('generalReturnOrders.close') }}
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>



        <div class="modal fade" id="general_load_model_approve">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-info">

                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('generalReturnOrders.approve_invoice') }}</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                    <input type="hidden" id="total" value="{{ $data['total_before_discount'] }}">
                    <input type="hidden" id="model_approve_route"
                        value="{{ route('general_return_orders.model_approve') }}">

                    <div class="modal-body bg-white text-dark">

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label>{{ __('generalReturnOrders.invoice_total_before_discount_tax') }}</label>
                                <input class="form-control" readonly id="general_total"
                                    value="{{ $data['total_before_discount'] / 100 }}">

                                @error('total_value')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('generalReturnOrders.enter_tax_percent') }}</label>
                                <input type="number" name="tax_percent" id="general_tax_percent" class="form-control">

                                @error('tax_percent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('generalReturnOrders.tax_value') }}</label>
                                <input type="number" readonly name="tax_value" id="general_tax_value" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('generalReturnOrders.enter_discount_percent') }}</label>
                                <input type="number" name="discount_percent" id="general_discount_percent"
                                    class="form-control">

                                @error('discount_percent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('generalReturnOrders.discount_value') }}</label>
                                <input type="number" readonly name="discount_value" id="general_discount_value"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('generalReturnOrders.final_total') }}</label>
                                <input type="number" readonly name="total_value" id="general_total_value" class="form-control">

                                @error('total_value')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('generalReturnOrders.current_treasury') }}</label>
                                <select class="form-control" id="general_treasuries_id" disabled>
                                    <option value="{{ $shift->treasuries_id }}" selected>
                                        {{ $shift->treasuries_name }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('generalReturnOrders.available_treasury_balance') }}</label>
                                <input class="form-control" readonly id="general_treasuries_balance"
                                    value="{{ $shift->treasuries_balance / 100 }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('generalReturnOrders.recevied_amount') }}</label>
                                <input class="form-control" id="general_what_received" name="what_received">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('generalReturnOrders.remain_amount') }}</label>
                                <input readonly class="form-control" id="general_what_remain" name="what_remain">

                                @error('what_remain')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-info" id="general_approve_bill">
                                        {{ __('generalReturnOrders.approve_invoice') }}
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                            {{ __('generalReturnOrders.close') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>



    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/general_return_orders.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
