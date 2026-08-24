@extends('layouts.admin');

@section('title')
    {{ __('salesBills.sales') }}
@endsection

@section('contentheader')
    {{ __('salesBills.inventory_transactions') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('sales_bills.index') }}"> {{ __('salesBills.sales_invoices') }} </a>
@endsection


@section('contentheaderactive')
    {{ __('salesBills.view') }}
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
                        {{ __('salesBills.sales_invoices_customers') }}
                    </h3>

                </div>


                <div class="card-body">

                    @if($shift)
                    <button type="button" class="btn btn-primary edititem" data-toggle="modal" data-target="#modal_mirrorbill">
                        {{ __('salesBills.quotation_invoice') }}
                    </button>

                    <button type="button" class="btn btn-success edititem" data-toggle="modal"
                        data-target="#modal_activebill">
                        {{ __('salesBills.add_actual_invoice') }}
                    </button>


                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <div id="ajax_responce_searchDiv" class="table-responsive">
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="custom_head">
                                        <tr>
                                            <th>{{ __('salesBills.invoice_code') }}</th>
                                            <th>{{ __('salesBills.customer_name') }}</th>
                                            <th>{{ __('salesBills.invoice_type') }}</th>
                                            <th>{{ __('salesBills.invoice_date') }}</th>
                                            <th>{{ __('salesBills.approval_status') }}</th>
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
                                                            {{ __('salesBills.cash') }}
                                                        </span>
                                                    @elseif($item->pill_type == 1)
                                                        <span class="badge bg-danger p-2">
                                                            {{ __('salesBills.credit') }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $item->invoice_date }}
                                                </td>

                                                <td>
                                                    @if ($item->is_approved == 0)
                                                        <span class="badge badge-danger p-2">
                                                            {{ __('salesBills.not_approved') }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success p-2">
                                                            {{ __('salesBills.approved') }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center gap-2">

                                                        <input type="hidden" id="get_active_bill_data_url"
                                                            value="{{ route('sales_item.get_active_bill_data') }}">

                                                        @if ($item->is_approved == 0)
                                                            <button type="button" class="btn btn-primary m-1 edit_bill"
                                                                style="width: 90px;"
                                                                data-autoserial="{{ $item->auto_serial }}">
                                                                {{ __('salesBills.edit') }}
                                                            </button>
                                                        @endif

                                                        @if ($item->is_approved == 1)
                                                            <button type="button" class="btn btn-info m-1 edit_bill"
                                                                style="width: 90px;"
                                                                data-autoserial="{{ $item->auto_serial }}">
                                                                {{ __('salesBills.details') }}
                                                            </button>
                                                        @endif

                                                        @if ($item->is_approved == 1)
                                                            <a href="{{ route('sales_bills.print', $item->auto_serial) }}"
                                                                class="btn btn-primary">
                                                                {{ __('salesBills.print') }}
                                                            </a>
                                                        @endif

                                                        <form
                                                            action="{{ route('sales_bills.destroy', $item->auto_serial) }}"
                                                            method="POST" class="deleteBillForm m-0">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger m-1"
                                                                style="width: 90px;">
                                                                {{ __('salesBills.delete') }}
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
                                {{ __('salesBills.no_data') }}
                            </div>
                    @endif

                    @else
                    <div class="alert alert-danger">
                        {{ __('salesBills.no_shift') }}
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_mirrorbill">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('salesBills.quotation_invoice') }}</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>



                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                <input type="hidden" id="mirror_sales_item_getUnits_url" value="{{ route('sales_item.mirrorgetUnits') }}">
                <input type="hidden" id="mirror_sales_item_get_batchs_url"
                    value="{{ route('sales_item.mirror_get_batchs') }}">
                <input type="hidden" id="sales_item_getprice_url" value="{{ route('sales_item.get_price') }}">

                <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">

                <input type="hidden" id="sales_item_getitems_url" value="{{ route('sales_item.get_add_items') }}">

                <div class="modal-body bg-white text-dark">

                    <div class="row p-3" style="border: 1px solid blue">

                        {{-- Store --}}
                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.store') }}</label>
                            <select class="form-control select2" id="mirror_store_id">
                                <option value="" selected disabled>
                                    {{ __('salesBills.select_store') }}
                                </option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">
                                        {{ $store->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.item') }}</label>
                            <select class="form-control select2" id="mirror_item_code">
                                <option value="" selected disabled>
                                    {{ __('salesBills.select_item') }}
                                </option>
                                @foreach ($items as $item)
                                    <option data-type="{{ $item->item_type }}" value="{{ $item->item_code }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-4 related_to_itemcard" style="display: none" id="mirror_unitsDiv"></div>

                        <div class="col-4 batchs" style="display: none" id="mirror_batchs_div"></div>

                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.sale_type') }}</label>
                            <select class="form-control" id="mirror_sale_type">
                                <option value="" selected disabled>
                                    {{ __('salesBills.select_sale_type') }}
                                </option>
                                <option value="0">
                                    {{ __('salesBills.wholesale') }}
                                </option>
                                <option value="1">
                                    {{ __('salesBills.half_wholesale') }}
                                </option>
                                <option value="2">
                                    {{ __('salesBills.retail') }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>{{ __('salesBills.quantity') }}</label>
                            <input type="number" class="form-control" id="mirror_quantity" name="quantity">

                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div style="display: none" id="mirror_price_div" class="form-group col-md-3">
                            <label>{{ __('salesBills.price') }}</label>
                            <input readonly type="number" class="form-control" id="mirror_price" name="price">
                        </div>

                        <div class="form-group col-md-3">
                            <label>{{ __('salesBills.final_total') }}</label>
                            <input type="number" readonly name="total_price" id="mirror_total_price"
                                class="form-control">

                            @error('total_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-group text-center">
                                <button type="button" class="btn btn-info" id="mirror_save_item">
                                    {{ __('salesBills.add_invoice') }}
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="row p-3" style="border: 1px solid blue">
                        <h4 class="form-control text-center">
                            {{ __('salesBills.invoice_items') }}
                        </h4>

                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>{{ __('salesBills.item') }}</th>
                                    <th>{{ __('salesBills.item_unit') }}</th>
                                    <th>{{ __('salesBills.sale_type') }}</th>
                                    <th>{{ __('salesBills.quantity') }}</th>
                                    <th>{{ __('salesBills.product_type') }}</th>
                                    <th>{{ __('salesBills.unit_price') }}</th>
                                    <th>{{ __('salesBills.total') }}</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody id="mirror_items_table">

                            </tbody>
                        </table>
                    </div>

                    <div class="row p-3" style="border: 1px solid blue">

                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.invoice_total_before_discount_tax') }}</label>
                            <input class="form-control" readonly id="mirror_total" value="{{ 0 / 100 }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.enter_tax_percent') }}</label>
                            <input type="number" name="tax_percent" id="mirror_tax_percent" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.tax_value') }}</label>
                            <input type="number" readonly name="tax_value" id="mirror_tax_value" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.enter_discount_percent') }}</label>
                            <input type="number" name="discount_percent" id="mirror_discount_percent"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.discount_value') }}</label>
                            <input type="number" readonly name="discount_value" id="mirror_discount_value"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>{{ __('salesBills.final_total') }}</label>
                            <input type="number" readonly name="total_value" id="mirror_total_value"
                                class="form-control">
                        </div>

                    </div>

                    <div class="text-center">
                        <a href="" class="btn btn-primary mt-3 p-2">
                            {{ __('salesBills.print_prices') }}
                        </a>
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                        {{ __('salesBills.close') }}
                    </button>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_activebill">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('salesBills.sales_invoice') }}</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                <input type="hidden" id="sales_item_getUnits_url" value="{{ route('sales_item.getUnits') }}">
                <input type="hidden" id="sales_item_get_batchs_url" value="{{ route('sales_item.get_batchs') }}">
                <input type="hidden" id="sales_item_getprice_url" value="{{ route('sales_item.get_price') }}">
                <input type="hidden" id="sales_item_getitems_url" value="{{ route('sales_item.get_add_items') }}">

                <input type="hidden" id="open_active_bill" value="{{ route('sales_item.open_active_bill') }}">

                <div class="modal-body bg-white text-dark">

                    <div class="row p-3" style="border: 1px solid blue">

                        <div class="form-group col-md-3">
                            <label>{{ __('salesBills.invoice_date') }}</label>
                            <input type="date" class="form-control" id="invoice_date" value="">

                            @error('invoice_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>{{ __('salesBills.invoice_categories') }}</label>
                            <select class="form-control select2" id="sales_material_type">
                                <option value="" selected disabled>
                                    {{ __('salesBills.select_invoice_category') }}
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
                                {{ __('salesBills.customer_account') }}
                                <a href="{{ route('customers.create') }}">
                                    {{ __('salesBills.add_new_customer') }}
                                </a>
                            </label>

                            <select class="form-control select2" id="customer_code">
                                <option value="" selected disabled>
                                    {{ __('salesBills.select_customer_account') }}
                                </option>

                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_code }}">
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>{{ __('salesBills.delegate_account') }}</label>

                            <select class="form-control select2" id="delegate_code">
                                <option value="" selected disabled>
                                    {{ __('salesBills.select_delegate_account') }}
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
                                <button type="button" id="open_active_bill" class="btn btn-primary p-2">
                                    {{ __('salesBills.add_invoice') }}
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                        {{ __('salesBills.close') }}
                    </button>
                </div>

            </div>

        </div>
    </div>


    <div class="modal fade" id="modal_billitems">

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
    <script src="{{ asset('assets/admin/js/sales_bills.js') }}"></script>
    <script src="{{ asset('assets/admin/js/mirror_sales_bills.js') }}"></script>
@endsection
