@extends('layouts.admin')

@section('title')
    {{ __('suppliersOrders.title') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('contentheader')
    {{ __('suppliersOrders.inventory_transactions') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('supplier_orders.index') }}">
        {{ __('suppliersOrders.supplier_orders') }}
    </a>
@endsection

@section('contentheaderactive')
    {{ __('suppliersOrders.show') }}
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
                        {{ __('suppliersOrders.invoice_data') }}
                    </h3>
                </div>

                <div class="card-body">
                    @if (isset($data))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <td class="width30">{{ __('suppliersOrders.auto_invoice_code') }}</td>
                                <td>{{ $data['auto_serial'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('suppliersOrders.supplier_invoice_code') }}</td>
                                <td>{{ $data['doc_number'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('suppliersOrders.invoice_date') }}</td>
                                <td>{{ $data['order_date'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('suppliersOrders.supplier_name') }}</td>
                                <td>{{ $data['supplier_name'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('suppliersOrders.invoice_type') }}</td>
                                <td>
                                    @if ($data['pill_type'] == 0)
                                        {{ __('suppliersOrders.cash') }}
                                    @else
                                        {{ __('suppliersOrders.deferred') }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('suppliersOrders.total_before_discount') }}</td>
                                <td>{{ $data['total_before_discount'] / 100 }}</td>
                            </tr>


                            @if ($data['descpunt_type'] != null)
                                <tr>
                                    <td class="width30">{{ __('suppliersOrders.invoice_discount_type') }}</td>

                                    @if ($data['discount_type'] == 1)
                                        <td>
                                            {{ __('suppliersOrders.percentage_discount') }}
                                            {{ $data['discount_percent'] }}
                                            {{ __('suppliersOrders.discount_value') }}
                                            {{ $data['discount_value'] }}
                                        </td>
                                    @else
                                        <td>
                                            {{ __('suppliersOrders.manual_discount') }}
                                            {{ __('suppliersOrders.discount_value') }}
                                            {{ $data['discount_value'] }}
                                        </td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <td class="width30">{{ __('suppliersOrders.invoice_discount_type') }}</td>
                                    <td>{{ __('suppliersOrders.no_discount') }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td class="width30">{{ __('suppliersOrders.taxes') }}</td>

                                @if ($data['tax_percent'] == 0 || $data['tax_percent'] == null)
                                    <td>{{ __('suppliersOrders.no_tax') }}</td>
                                @else
                                    <td>
                                        {{ __('suppliersOrders.tax_percentage') }}
                                        {{ $data['tax_percent'] }}
                                        {{ __('suppliersOrders.discount_value') }}
                                        {{ $data['tax_value'] }}
                                    </td>
                                @endif
                            </tr>

                            <tr>
                                <td class="width30">{{ __('suppliersOrders.total_after_discount') }}</td>
                                <td>{{ $data['total_cost'] / 100 }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('suppliersOrders.store') }}</td>
                                <td>{{ $data['store_name'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('suppliersOrders.added_at') }}</td>
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
                                        {{ __('suppliersOrders.added_by') }}
                                        {{ $data['added_by_admin'] }}
                                    @else
                                        {{ __('suppliersOrders.no_data') }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('suppliersOrders.updated_at') }}</td>
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
                                        {{ __('suppliersOrders.added_by') }}
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        {{ __('suppliersOrders.no_data') }}
                                    @endif
                                </td>
                            </tr>



                            <tr>
                                <td>
                                    @if ($data['is_approved'] == 0)
                                        <a href="{{ route('supplier_orders.edit', $data->id) }}"
                                            class="btn btn-primary text-white">
                                            {{ __('suppliersOrders.edit') }}
                                        </a>

                                        <button type="button" class="btn btn-success m-2" data-toggle="modal"
                                            data-target="#load_model_approve">
                                            {{ __('suppliersOrders.approve') }}
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        @if ($data['is_approved'] == 0)
                            <button type="button" class="btn btn-info m-2" data-toggle="modal"
                                data-target="#add_item_model">
                                {{ __('suppliersOrders.add_item_to_invoice') }}
                            </button>
                        @endif

                        <br>
                    @else
                        <div class="alert alert-warning">
                            {{ __('suppliersOrders.no_data') }}
                        </div>
                    @endif



                    @if (isset($details) && count($details) > 0)
                        <div class="card-header">
                            <h3 class="card-title card_title_center">
                                {{ __('suppliersOrders.invoice_items') }}
                            </h3>
                        </div>

                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>{{ __('suppliersOrders.serial') }}</th>
                                    <th>{{ __('suppliersOrders.item_name') }}</th>
                                    <th>{{ __('suppliersOrders.item_unit') }}</th>
                                    <th>{{ __('suppliersOrders.unit_price') }}</th>
                                    <th>{{ __('suppliersOrders.quantity') }}</th>
                                    <th>{{ __('suppliersOrders.total') }}</th>
                                    <th>{{ __('suppliersOrders.production_date') }}</th>
                                    <th>{{ __('suppliersOrders.expiry_date') }}</th>

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
                                        <td>{{ $bill_item->production_date }}</td>
                                        <td>{{ $bill_item->end_date }}</td>

                                        @if ($data['is_approved'] == 0)
                                            <td>
                                                <button type="button" class="btn btn-primary edititem" data-toggle="modal"
                                                    data-id="{{ $bill_item->id }}" data-target="#edit_item_model">
                                                    {{ __('suppliersOrders.edit') }}
                                                </button>

                                                <form
                                                    action="{{ route('supplier_orders.destroy_details', $bill_item->id) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('{{ __('suppliersOrders.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger">
                                                        {{ __('suppliersOrders.delete') }}
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
                            {{ __('suppliersOrders.no_data') }}
                        </div>
                    @endif



                </div>

            </div>
        </div>

        <div class="modal fade" id="add_item_model">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('suppliersOrders.add_items') }}</h4>
                        <button type="button" class="close color-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                    <input type="hidden" id="ajax_getUnits_url" value="{{ route('supplier_orders.getUnits') }}">
                    <input type="hidden" id="ajax_addunits" value="{{ route('supplier_orders.addunits') }}">
                    <input type="hidden" id="ajax_edititem" value="{{ route('supplier_orders.edititem') }}">
                    <input type="hidden" id="ajax_updateitem" value="{{ route('supplier_orders.update_item') }}">

                    <div class="modal-body" id="model_body" style="background-color: white !important; color: black;">
                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label>{{ __('suppliersOrders.item_data') }}</label>

                                    <select id="item_card_add" name="items" class="form-control select2">
                                        <option value="" selected disabled>
                                            {{ __('suppliersOrders.select_item') }}
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

                            <div class="col-4 related_to_itemcard" style="display: none">
                                <div class="form-group">
                                    <label>{{ __('suppliersOrders.received_quantity') }}</label>

                                    <input type="number" id="quantity_add" name="quantity_add" class="form-control"
                                        value="">
                                </div>
                            </div>

                            <div class="col-4 related_to_itemcard" style="display: none">
                                <div class="form-group">
                                    <label>{{ __('suppliersOrders.price') }}</label>

                                    <input type="number" id="price_add" name="price_add" class="form-control"
                                        value="">
                                </div>
                            </div>

                            <div class="col-4 related_to_date" style="display: none">
                                <div class="form-group">
                                    <label>{{ __('suppliersOrders.production_date') }}</label>

                                    <input type="date" id="production_date" name="production_date"
                                        class="form-control" value="">
                                </div>
                            </div>

                            <div class="col-4 related_to_date" style="display: none">
                                <div class="form-group">
                                    <label>{{ __('suppliersOrders.expiry_date') }}</label>

                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="">
                                </div>
                            </div>

                            <div class="col-4 related_to_itemcard" style="display: none">
                                <div class="form-group">
                                    <label>{{ __('suppliersOrders.grand_total') }}</label>

                                    <input readonly type="number" id="total_price" name="total_price"
                                        class="form-control" value="">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-info" id="addtobill">
                                        {{ __('suppliersOrders.add_items_button') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                            {{ __('suppliersOrders.close') }}
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>



        <div class="modal fade" id="edit_item_model">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('suppliersOrders.update_item') }}</h4>
                        <button type="button" class="close color-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                    <input type="hidden" id="ajax_getUnits_url" value="{{ route('supplier_orders.getUnits') }}">
                    <input type="hidden" id="ajax_addunits" value="{{ route('supplier_orders.addunits') }}">
                    <input type="hidden" id="ajax_edititem" value="{{ route('supplier_orders.edititem') }}">

                    <div class="modal-body" id="edit_item_model_body"
                        style="background-color: white !important; color: black;">

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                            {{ __('suppliersOrders.close') }}
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <div class="modal fade" id="load_model_approve">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-info">

                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('suppliersOrders.approve_invoice') }}</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                    <input type="hidden" id="total" value="{{ $data['total_before_discount'] }}">
                    <input type="hidden" id="model_approve_route"
                        value="{{ route('supplier_orders.model_approve') }}">

                    <div class="modal-body bg-white text-dark">

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label>{{ __('suppliersOrders.invoice_total_before_discount_tax') }}</label>
                                <input class="form-control" readonly id="total"
                                    value="{{ $data['total_before_discount'] / 100 }}">

                                @error('total_value')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('suppliersOrders.enter_tax_percent') }}</label>
                                <input type="number" name="tax_percent" id="tax_percent" class="form-control">

                                @error('tax_percent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('suppliersOrders.tax_value') }}</label>
                                <input type="number" readonly name="tax_value" id="tax_value" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('suppliersOrders.enter_discount_percent') }}</label>
                                <input type="number" name="discount_percent" id="discount_percent"
                                    class="form-control">

                                @error('discount_percent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('suppliersOrders.discount_value') }}</label>
                                <input type="number" readonly name="discount_value" id="discount_value"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('suppliersOrders.final_total') }}</label>
                                <input type="number" readonly name="total_value" id="total_value" class="form-control">

                                @error('total_value')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('suppliersOrders.current_treasury') }}</label>
                                <select class="form-control" id="treasuries_id" disabled>
                                    <option value="{{ $shift->treasuries_id }}" selected>
                                        {{ $shift->treasuries_name }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{ __('suppliersOrders.available_treasury_balance') }}</label>
                                <input class="form-control" readonly id="treasuries_balance"
                                    value="{{ $shift->treasuries_balance / 100 }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('suppliersOrders.paid_amount') }}</label>
                                <input class="form-control" id="what_paid" name="what_paid">

                                @error('what_paid')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('suppliersOrders.remaining_amount') }}</label>
                                <input readonly class="form-control" id="what_remain" name="what_remain">

                                @error('what_remain')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-info" id="approve_bill">
                                        {{ __('suppliersOrders.approve_invoice') }}
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                            {{ __('suppliersOrders.close') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>



    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/supplier_orders.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
