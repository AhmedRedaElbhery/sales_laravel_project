@extends('layouts.admin');

@section('title')
    {{ __('returnSalesBills.sales') }}
@endsection

@section('contentheader')
    {{ __('returnSalesBills.inventory_transactions') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('general_return_sales_order.index') }}"> {{ __('returnSalesBills.sales_invoices') }} </a>
@endsection


@section('contentheaderactive')
    {{ __('returnSalesBills.view') }}
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
                        {{ __('returnSalesBills.sales_invoices_customers') }}
                    </h3>

                </div>


                <div class="card-body">

                    @if($shift)

                    <button type="button" class="btn btn-success edititem" data-toggle="modal"
                        data-target="#general_return_sales_orders_modal_activebill">
                        {{ __('returnSalesBills.add_actual_invoice') }}
                    </button>


                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <div id="ajax_responce_searchDiv" class="table-responsive">
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="custom_head">
                                        <tr>
                                            <th>{{ __('returnSalesBills.invoice_code') }}</th>
                                            <th>{{ __('returnSalesBills.customer_name') }}</th>
                                            <th>{{ __('returnSalesBills.invoice_type') }}</th>
                                            <th>{{ __('returnSalesBills.invoice_date') }}</th>
                                            <th>{{ __('returnSalesBills.approval_status') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->auto_serial }}</td>

                                                <td>{{ $item->customer_name }}</td>

                                                <td>
                                                    @if ($item->pill_type === 0)
                                                        <span class="badge bg-success p-2">
                                                            {{ __('returnSalesBills.cash') }}
                                                        </span>
                                                    @elseif($item->pill_type == 1)
                                                        <span class="badge bg-danger p-2">
                                                            {{ __('returnSalesBills.credit') }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $item->invoice_date }}
                                                </td>

                                                <td>
                                                    @if ($item->is_approved == 0)
                                                        <span class="badge badge-danger p-2">
                                                            {{ __('returnSalesBills.not_approved') }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success p-2">
                                                            {{ __('returnSalesBills.approved') }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center gap-2">

                                                        <input type="hidden" id="general_return_sales_orders_get_active_bill_data_url"
                                                            value="{{  route('general_return_sales_order.get_active_bill_data') }}">

                                                        @if ($item->is_approved == 0)
                                                            <button type="button" class="btn btn-primary m-1 edit_bill"
                                                                style="width: 90px;"
                                                                data-autoserial="{{ $item->auto_serial }}">
                                                                {{ __('returnSalesBills.edit') }}
                                                            </button>
                                                        @endif

                                                        @if ($item->is_approved == 1)
                                                            <button type="button" class="btn btn-info m-1 edit_bill"
                                                                style="width: 90px;"
                                                                data-autoserial="{{ $item->auto_serial }}">
                                                                {{ __('returnSalesBills.details') }}
                                                            </button>
                                                        @endif

                                                        @if ($item->is_approved == 1)
                                                            <a href="{{ route('general_return_sales_order.print', $item->auto_serial) }}"
                                                                class="btn btn-primary">
                                                                {{ __('returnSalesBills.print') }}
                                                            </a>
                                                        @endif

                                                        <form
                                                            action="{{ route('general_return_sales_order.destroy', $item->auto_serial) }}"
                                                            method="POST" class="deleteBillForm m-0">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger m-1"
                                                                style="width: 90px;">
                                                                {{ __('returnSalesBills.delete') }}
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <br>

                                        <div class="mt-3">
                                            {{ $data->links() }}
                                        </div>
                                    </tbody>

                                </table>

                            </div>
                        @else
                            <div class="alert alert-warning">
                                {{ __('returnSalesBills.no_data') }}
                            </div>
                    @endif

                    @else
                    <div class="alert alert-danger">
                        {{ __('returnSalesBills.no_shift') }}
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>



    <div class="modal fade" id="general_return_sales_orders_modal_activebill">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('returnSalesBills.sales_invoice') }}</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                <input type="hidden" id="general_return_sales_orders_autoserialparent" value="{{ $data['auto_serial'] }}">
                <input type="hidden" id="general_return_sales_order_getUnits_url" value="{{  route('general_return_sales_order.getUnits') }}">
                <input type="hidden" id="general_return_sales_order_getitems_url" value="{{  route('general_return_sales_order.get_add_items') }}">

                <input type="hidden" id="general_return_sales_orders_open_active_bill" value="{{  route('general_return_sales_order.open_active_bill') }}">

                <div class="modal-body bg-white text-dark">

                    <div class="row p-3" style="border: 1px solid blue">

                        <div class="form-group col-md-3">
                            <label>{{ __('returnSalesBills.invoice_date') }}</label>
                            <input type="date" class="form-control" id="general_return_sales_orders_invoice_date" value="">

                            @error('invoice_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>{{ __('returnSalesBills.invoice_categories') }}</label>
                            <select class="form-control select2" id="general_return_sales_orders_sales_material_type">
                                <option value="" selected disabled>
                                    {{ __('returnSalesBills.select_invoice_category') }}
                                </option>
                                @foreach ($sales_material_types as $sales_material_type)
                                    <option value="{{ $sales_material_type->id }}">
                                        {{ $sales_material_type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>
                                {{ __('returnSalesBills.customer_account') }}
                                <a href="{{ route('customers.create') }}">
                                    {{ __('returnSalesBills.add_new_customer') }}
                                </a>
                            </label>

                            <select class="form-control select2" id="general_return_sales_orders_customer_code">
                                <option value="" selected disabled>
                                    {{ __('returnSalesBills.select_customer_account') }}
                                </option>

                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_code }}">
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>{{ __('returnSalesBills.delegate_account') }}</label>

                            <select class="form-control select2" id="general_return_sales_orders_delegate_code">
                                <option value="" selected disabled>
                                    {{ __('returnSalesBills.select_delegate_account') }}
                                </option>

                                @foreach ($delegates as $delegate)
                                    <option value="{{ $delegate->delegate_code }}">
                                        {{ $delegate->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group text-center">
                                <button type="button" id="general_return_sales_orders_open_active_bill" class="btn btn-primary p-2">
                                    {{ __('returnSalesBills.add_invoice') }}
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                        {{ __('returnSalesBills.close') }}
                    </button>
                </div>

            </div>

        </div>
    </div>


    <div class="modal fade" id="general_return_sales_orders_modal_billitems">

    </div>

    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
            });
            $('.select2-selection').height(24);
            $('.select2-selection__rendered').css('line-height', '24px');
            $('.select2-selection__arrow').height(24);
        });
    </script>
    <script src="{{ asset('assets/admin/js/general_return_sales_bills.js') }}"></script>
@endsection
