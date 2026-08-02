@if ($isapproved != 1)

    @if (!empty($item_cards))

        @if (!empty($item_data))

            <div class="row">

                <div class="col-4">

                    <div class="form-group">
                        <input id="id" type="number" hidden value="{{ $item_data->id }}">

                        <label>{{ __('suppliersOrders.item_data') }}</label>

                        <select id="item_card_add" name="items" class="form-control select2">
                            <option value="" selected disabled>
                                {{ __('suppliersOrders.select_item') }}
                            </option>

                            @if (isset($item_cards))
                                @foreach ($item_cards as $item)
                                    <option disabled
                                        @selected($item->item_code == $item_data->item_code)
                                        data-type="{{ $item->item_type }}"
                                        value="{{ $item->item_code }}">
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

                <div class="col-4 related_to_itemcard" id="unitsDiv">

                    <div class="form-group">
                        <label>{{ __('suppliersOrders.item_units') }}</label>

                        <select id="unit_id_edit" name="units" class="form-control select2">
                            <option value="" selected disabled>
                                {{ __('suppliersOrders.select_unit') }}
                            </option>

                            @if (isset($item_card_data) && $item_card_data != null)

                                @if ($item_card_data->has_retail_unit == 1)
                                    <option
                                        data-isparentunit="1"
                                        @selected($item_data->unit_id == $item_card_data->parent_unit_id)
                                        value="{{ $item_card_data->parent_unit_id }}">
                                        {{ $item_card_data->parent_unit_name }}
                                        ({{ __('suppliersOrders.main_unit') }})
                                    </option>

                                    <option
                                        data-isparentunit="0"
                                        @selected($item_data->unit_id == $item_card_data->retail_unit_id)
                                        value="{{ $item_card_data->retail_unit_id }}">
                                        {{ $item_card_data->retail_unit_name }}
                                        ({{ __('suppliersOrders.retail_unit') }})
                                    </option>
                                @else
                                    <option
                                        data-isparentunit="1"
                                        selected
                                        value="{{ $item_card_data->parent_unit_id }}">
                                        {{ $item_card_data->parent_unit_name }}
                                        ({{ __('suppliersOrders.main_unit') }})
                                    </option>
                                @endif

                            @endif

                        </select>

                        @error('unit_id_add')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="col-4 related_to_itemcard">

                    <div class="form-group">
                        <label>{{ __('suppliersOrders.received_quantity') }}</label>

                        <input type="number"
                            id="quantity_edit"
                            name="quantity_add"
                            class="form-control"
                            value="{{ $item_data->delivered_quantity * 1 }}">
                    </div>
                </div>

                <div class="col-4 related_to_itemcard">

                    <div class="form-group">
                        <label>{{ __('suppliersOrders.price') }}</label>

                        <input type="number"
                            id="price_edit"
                            name="price_add"
                            class="form-control"
                            value="{{ $item_data->unit_price / 100 }}">
                    </div>
                </div>

                @if ($item_data->production_date != null && $item_data->end_date != null)

                    <div class="col-4 related_to_date">

                        <div class="form-group">
                            <label>{{ __('suppliersOrders.production_date') }}</label>

                            <input type="date"
                                id="production_date_edit"
                                name="production_date"
                                class="form-control"
                                value="{{ $item_data->production_date }}">
                        </div>
                    </div>

                    <div class="col-4 related_to_date">

                        <div class="form-group">
                            <label>{{ __('suppliersOrders.expiry_date') }}</label>

                            <input type="date"
                                id="end_date_edit"
                                name="end_date"
                                class="form-control"
                                value="{{ $item_data->end_date }}">
                        </div>
                    </div>

                @endif

                <div class="col-4 related_to_itemcard">

                    <div class="form-group">
                        <label>{{ __('suppliersOrders.grand_total') }}</label>

                        <input readonly
                            type="number"
                            id="total_price_edit"
                            name="total_price"
                            class="form-control"
                            value="{{ $item_data->total_price / 100 }}">
                    </div>
                </div>

                <div class="col-12">

                    <div class="form-group text-center">
                        <button type="button"
                            class="btn btn-info"
                            id="update_items">
                            {{ __('suppliersOrders.save') }}
                        </button>
                    </div>
                </div>

            </div>

        @else

            <div class="alert alert-danger">
                {{ __('suppliersOrders.no_data') }}
            </div>

        @endif

    @else

        <div class="alert alert-danger">
            {{ __('suppliersOrders.no_data') }}
        </div>

    @endif

@else

    <div class="alert alert-danger">
        {{ __('suppliersOrders.cannot_update_archived') }}
    </div>

@endif