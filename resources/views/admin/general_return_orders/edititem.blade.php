@if ($isapproved != 1)

    @if (!empty($itemCards))

        @if (!empty($itemData))

            <div class="row">

                <div class="col-4">

                    <div class="form-group">
                        <input id="id" type="number" hidden value="{{ $itemData->id }}">

                        <label>{{ __('suppliersOrders.item_data') }}</label>

                        <select id="general_item_card_edit" name="items" class="form-control select2">

                            @if (isset($itemCards))
                                @foreach ($itemCards as $item)
                                    <option @if($item->item_code == $itemData->item_code) selected @else disabled @endif data-type="{{ $item->item_type }}"
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

                        <select id="general_unit_id_edit" name="units" class="form-control select2">
                            <option value="" selected disabled>
                                {{ __('suppliersOrders.select_unit') }}
                            </option>

                            @if (isset($itemCardData) && $itemCardData != null)

                                @if ($itemCardData->has_retail_unit == 1)
                                    <option data-isparentunit="1" @if($itemData->unit_id == $itemCardData->parent_unit_id) selected @else disabled @endif
                                        value="{{ $itemCardData->parent_unit_id }}">
                                        {{ $itemCardData->parent_unit_name }}
                                        ({{ __('suppliersOrders.main_unit') }})
                                    </option>

                                    <option data-isparentunit="0" @if($itemData->unit_id == $itemCardData->retail_unit_id) selected @else disabled @endif
                                        value="{{ $itemCardData->retail_unit_id }}">
                                        {{ $itemCardData->retail_unit_name }}
                                        ({{ __('suppliersOrders.retail_unit') }})
                                    </option>
                                @else
                                    <option data-isparentunit="1" selected value="{{ $itemCardData->parent_unit_id }}">
                                        {{ $itemCardData->parent_unit_name }}
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


                <div class="col-4">
                    <div class="form-group">
                        <label>{{ __('suppliersOrders.item_units') }}</label>
                        <select disabled id="batch_id" name="batch_id" class="form-control">
                            <option value="{{ $batch->id }}" selected disabled>
                                الكميه المتاحه {{ $batch->quantity * 1 }}
                            </option>

                        </select>

                    </div>
                </div>

                <div class="col-4 related_to_itemcard">

                    <div class="form-group">
                        <label>{{ __('generalreturnorders.return_quantity') }}</label>

                        <input type="number" id="edit_return_quantity" name="edit_return_quantity" class="form-control"
                            value="{{ $itemData->delivered_quantity * 1 }}">
                    </div>
                </div>

                <div class="col-12">

                    <div class="form-group text-center">
                        <button type="button" class="btn btn-info" id="general_update_items">
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
