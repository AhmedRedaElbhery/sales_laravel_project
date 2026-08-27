<div class="modal-dialog modal-xl">
    <div class="modal-content bg-info">

        <div class="modal-header">
            <h4 class="modal-title">{{__('salesBills.add_items')}}</h4>
            <button type="button" class="close text-white" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <input type="hidden" id="token_search" value="{{ csrf_token() }}">
        <input type="hidden" id="general_return_sales_orders_autoserial" value="{{ $data['auto_serial'] }}">

        <input type="hidden" id="general_return_sales_orders_save_active_billitems_url" value="{{ route('general_return_sales_order.save_active_billitems') }}">

        <input type="hidden" id="general_return_sales_orders_active_add_items_url" value="{{ route('general_return_sales_order.active_add_items') }}">

        <input type="hidden" id="general_return_sales_orders_active_delete_all_items" value="{{ route('general_return_sales_order.active_delete_all_items') }}">


        <input type="hidden" id="general_return_sales_orders_approve_active_bill_url" value="{{ route('general_return_sales_order.approve_active_bill') }}">




        <div class="modal-body bg-white text-dark" id="general_return_sales_orders_bill_model">

            <div class="row p-3" style="border: 1px solid blue">

                <div class="form-group col-md-3">
                    <label> {{ __('returnSalesBills.invoice_date') }}</label>
                    <input type="date" class="form-control" id="general_return_sales_orders_update_invoice_date"
                        value="{{ $data->invoice_date }}">

                    @error('invoice_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label> {{ __('returnSalesBills.invoice_categories') }}</label>
                    <select class="form-control select2" id="general_return_sales_orders_update_sales_material_type">
                        <option value="" selected disabled>
                             {{ __('returnSalesBills.select_invoice_category') }}
                        </option>
                        @foreach ($sales_material_types as $sales_material_type)
                            <option value="{{ $sales_material_type->id }}"
                                @if ($data->sales_material_type_id == $sales_material_type->id) selected @endif>
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

                    <select class="form-control select2" id="general_return_sales_orders_update_customer_code">
                        <option value="" selected disabled>
                             {{ __('returnSalesBills.select_customer_account') }}
                        </option>

                        @foreach ($customers as $customer)
                            <option value="{{ $customer->customer_code }}"
                                @if ($data->customer_code == $customer->customer_code) selected @endif>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group col-md-3">
                    <label> {{ __('returnSalesBills.delegate_account') }}</label>

                    <select class="form-control select2" id="general_return_sales_orders_update_delegate_code">
                        <option value="" selected disabled>
                             {{ __('returnSalesBills.select_delegate_account') }}
                        </option>

                        @foreach ($delegates as $delegate)
                            <option value="{{ $delegate->delegate_code }}"
                                @if ($data->delegate_code == $delegate->delegate_code) selected @endif>
                                {{ $delegate->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

            </div>

            @if ($is_approved == 0)

                <div class="row p-3" style="border: 1px solid blue">


                    <div class="form-group col-md-4">
                        <label> {{ __('returnSalesBills.store') }}</label>

                        <select class="form-control select2" id="general_return_sales_orders_store">
                            <option value="" selected disabled>
                                 {{ __('returnSalesBills.choose_store') }}
                            </option>
                            @foreach ($stores as $store)
                                <option  value="{{ $store->id }}">
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>


                    <div class="form-group col-md-4">
                        <label> {{ __('returnSalesBills.item') }}</label>

                        <select class="form-control select2" id="general_return_sales_orders_item_code">
                            <option value="" selected disabled>
                                 {{ __('returnSalesBills.select_item') }}
                            </option>

                            @foreach ($items as $item)
                                <option data-type="{{ $item->item_type }}" value="{{ $item->item_code }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-4 related_itemcard" style="display: none" id="general_return_sales_orders_unitsDiv"></div>

                    <div class="form-group col-md-4 related_itemcard_date" style="display: none">
                        <label> {{ __('returnSalesBills.production_date') }}</label>

                        <input
                            type="date"
                            class="form-control"
                            id="general_return_sales_orders_production_date"
                            name="production_date"
                            value=""
                        >
                    </div>

                    <div class="form-group col-md-4 related_itemcard_date" style="display: none">
                        <label> {{ __('returnSalesBills.end_date') }}</label>

                        <input
                            type="date"
                            class="form-control"
                            id="general_return_sales_orders_end_date"
                            name="end_date"
                            value=""
                        >
                    </div>

                    <div class="form-group col-md-4">
                        <label> {{ __('returnSalesBills.sale_type') }}</label>

                        <select class="form-control" id="general_return_sales_orders_sale_type">
                            <option value="" selected disabled>
                                 {{ __('returnSalesBills.select_sale_type') }}
                            </option>

                            <option value="0">
                                 {{ __('returnSalesBills.wholesale') }}
                            </option>

                            <option value="1">
                                 {{ __('returnSalesBills.half_wholesale') }}
                            </option>

                            <option value="2">
                                 {{ __('returnSalesBills.retail') }}
                            </option>
                        </select>

                    </div>

                    <div class="form-group col-md-3">
                        <label> {{ __('returnSalesBills.quantity') }}</label>

                        <input type="number" value="" class="form-control" id="general_return_sales_orders_quantity" name="quantity">

                        @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="general_return_sales_orders_price_div" class="form-group col-md-3">
                        <label> {{ __('returnSalesBills.price') }}</label>

                        <input type="number" value="" class="form-control" id="general_return_sales_orders_price"
                            name="price">
                    </div>

                    <div class="form-group col-md-3">
                        <label> {{ __('returnSalesBills.final_total') }}</label>

                        <input type="number" value="" readonly name="total_price" id="general_return_sales_orders_total_price"
                            class="form-control">

                        @error('total_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($data->is_approved == 0)
                        <div class="col-12">

                            <div class="form-group text-center">
                                <button type="button" class="btn btn-info" id="general_return_sales_orders_save_edit_item">
                                     {{ __('returnSalesBills.add_invoice') }}
                                </button>
                            </div>

                        </div>
                    @endif

                </div>

            @endif

            <div class="row p-3" style="border: 1px solid blue">

                <h4 class="form-control text-center">
                     {{ __('returnSalesBills.invoice_items') }}
                </h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="custom_head">
                            <tr>

                                <th> {{ __('returnSalesBills.item') }}</th>
                                <th> {{ __('returnSalesBills.item_unit') }}</th>
                                <th> {{ __('returnSalesBills.production_date') }}</th>
                                <th> {{ __('returnSalesBills.end_date') }}</th>
                                <th> {{ __('returnSalesBills.product_type') }}</th>
                                <th> {{ __('returnSalesBills.quantity') }}</th>
                                <th> {{ __('returnSalesBills.unit_price') }}</th>
                                <th> {{ __('returnSalesBills.total') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="general_return_sales_orders_table_items">
                            @include('admin.general_return_sales_orders.get_add_items',[
                                 'bill_details' => $bill_details,
                            ])
                        </tbody>
                    </table>
                </div>

            </div>


            <div class="row p-3" style="border: 1px solid blue">

                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.invoice_total_before_discount_tax') }}</label>

                    <input class="form-control" readonly id="general_return_sales_orders_total" value="{{ $total_bill_cost / 100 }}">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.enter_tax_percent') }}</label>

                    <input type="number" name="tax_percent" value="{{ $data->tax_percent }}" id="general_return_sales_orders_tax_percent"
                        class="form-control">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.tax_value') }}</label>

                    <input type="number" readonly name="tax_value" value="{{ $data->tax_value }}" id="general_return_sales_orders_tax_value"
                        class="form-control">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.enter_discount_percent') }}</label>

                    <input type="number" name="discount_percent" value="{{ $data->discount_percent }}"
                        id="general_return_sales_orders_discount_percent" class="form-control">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.discount_value') }}</label>

                    <input type="number" readonly name="discount_value" value="{{ $data->discount_value }}"
                        id="general_return_sales_orders_discount_value" class="form-control">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.final_total') }}</label>

                    <input type="number" readonly name="total_value" value="{{ $data->total_cost / 100 }}"
                        id="general_return_sales_orders_total_value" class="form-control">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.bill_type') }}</label>

                    <select class="form-control" id="general_return_sales_orders_bill_type">

                        <option value="" selected disabled>
                             {{ __('returnSalesBills.select_bill_type') }}
                        </option>

                        <option @if ($data->pill_type == 0) selected @endif value="0">
                             {{ __('returnSalesBills.cash') }}
                        </option>

                        <option value="1" @if ($data->pill_type == 1) selected @endif>
                             {{ __('returnSalesBills.credit') }}
                        </option>

                    </select>
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.current_treasury') }}</label>

                    <select class="form-control" id="general_return_sales_orders_treasuries_id" disabled>
                        <option value="{{ $shift->treasuries_id }}" selected>
                            {{ $shift->treasuries_name }}
                        </option>
                    </select>
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.treasury_available_balance') }}</label>

                    <input class="form-control" readonly id="general_return_sales_orders_treasuries_balance"
                        value="{{ $shift->treasuries_balance / 100 }}">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.paid_amount') }}</label>

                    <input class="form-control" value="{{ $data->what_paid / 100}}" id="general_return_sales_orders_what_paid" name="what_paid">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.remaining_amount') }}</label>

                    <input readonly class="form-control" value="{{ $data->what_remain / 100}}" id="general_return_sales_orders_what_remain"
                        name="what_remain">
                </div>


                <div class="form-group col-md-4">
                    <label> {{ __('returnSalesBills.notes') }}</label>

                    <textarea id="general_return_sales_orders_notes" class="form-control">{{ $data->notes }}</textarea>
                </div>

            </div>


            @if ($data->is_approved == 0)
                <div class="col-12">

                    <div class="form-group text-center">
                        <button type="button" id="general_return_sales_orders_approve_sale_bill" class="btn btn-success p-2 mt-3"
                            style="width: 100px">
                             {{ __('returnSalesBills.approve') }}
                        </button>
                    </div>

                </div>
            @endif



        </div>

        <div class="modal-footer justify-content-between">

        </div>

    </div>

</div>
