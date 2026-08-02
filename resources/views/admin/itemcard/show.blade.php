@extends('layouts.admin');

@section('title')
    {{ __('items.title') }}
@endsection

@section('contentheader')
{{ __('items.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('itemcard.index') }}"> {{ __('items.title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('items.show') }}
@endsection


@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">{{ __('items.item_data') }}</h3>
        </div>

        <div class="card-body border border-dark">

            <div>
                <div class="row mb-2">
                    <div class="form-group col-sm-6">
                        <label> - {{ __('items.barcode_item') }} : </label>
                        <td> {{ $data->barcode }} </td>
                    </div>

                    <div class="form-group col-sm-6">
                        <label> - {{ __('items.name') }} : </label>
                        <td> {{ $data->name }} </td>
                    </div>
                </div>


                <div class="row mb-2">

                    <div class="form-group col-sm-6">
                        <label> - {{ __('items.type') }} : </label>
                        <tr>
                            @if ($data->item_type == 1)
                            {{ __('items.stock_item') }}
                            @elseif ($data->item_type == 2)
                            {{ __('items.consumable_expiry') }}
                            @elseif($data->item_type == 3)
                            {{ __('items.asset_item') }}
                            @endif
                        </tr>
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="ml-1"> - {{ __('items.category') }} : </label>
                        <tr>{{ $data->category->name }}
                        </tr>
                    </div>
                </div>


                <div class="row mb-2">

                    <div class="form-group col-sm-6">
                        <label class="ml-1"> - {{ __('items.the_main_item') }} : </label>
                        <tr>
                            @if ($data->parent_id == 0)
                            {{ __('items.main_item') }}
                            @else
                                {{ $data->items->name }}
                            @endif

                        </tr>
                    </div>

                    <div class="form-group col-sm-6">
                        <label> - {{ __('items.main_unit_of_item') }} : </label>
                        <tr>
                            {{ $data->units->name }}
                        </tr>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="form-group col-sm-6">

                        <label> - {{ __('items.whole_price') }}(<span class="text-muted name_parent_unit">{{ $data->units->name }}
                            </span>) : </label>
                        <td>{{ $data->Wholesale_price / 100 }} </td>
                    </div>

                    <div class="form-group col-sm-6">
                        <label> - {{ __('items.part_whole_price') }}(<span class="name_parent_unit text-muted">
                                {{ $data->units->name }}</span>) :</label>
                        <td>{{ $data->half_Wholesale_price / 100 }} </td>
                    </div>
                </div>

                <div class="row mb-2">

                    <div class="form-group col-sm-6">
                        <label> - {{ __('items.part_price') }} (<span class="name_parent_unit text-muted">{{ $data->units->name }}
                            </span>)
                            : </label>
                        <td>{{ $data->price / 100 }} </td>

                    </div>

                    <div class="form-group col-sm-6">
                        <label> - {{ __('items.cost_price') }}(<span class="name_parent_unit text-muted">{{ $data->units->name }}
                            </span>) :</label>
                        <td>{{ $data->cost_price / 100 }} </td>
                    </div>
                </div>


                <div class="form-group col-5 mt-3 mb-4">
                    <label> - {{ __('items.has_retail_unit') }} :</label>
                    <td name="has_retail_unit" id="retail_options" class="form-control">
                        @if ($data->has_retail_unit == 1)
                        {{ __('items.yes') }}
                        @elseif($data->has_retail_unit == 0)
                        {{ __('items.no') }}
                        @endif
                    </td>
                </div>
                @if ($data->has_retail_unit == '1')
                <div class="row mb-2">

                    <div class="form-group col-sm-6 retail_divs"
                        @if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - {{ __('items.the_retail_unit') }} :</label>
                        <td>

                                {{ $data->retail_units->name }}
                        </td>
                    </div>

                    <div class="form-group col-sm-6 retail_divs"
                        @if ($data->has_retail_unit != '1') style="display:none" @endif>

                        <label> - {{ __('items.retail_unit_number') }} (<span
                                class="name_retail_unit text-muted ">{{ $data->retail_units->name }}
                            </span>)  (<span class="name_parent_unit text-muted ">{{ $data->units->name }} </span>)
                            :</label>
                        <td> {{ $data->retail_unit_to_parent }} </td>
                    </div>
                </div>


                <div class="row mb-2">

                    <div
                        class="form-group col-sm-6 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - {{ __('items.whole_price') }} (<span class="name_retail_unit text-muted">
                                {{ $data->retail_units->name }}</span>) :</label>
                        <td> {{ $data->retail_Wholesale_price / 100 }} </td>
                    </div>


                    <div
                        class="form-group col-sm-6 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - {{ __('items.part_whole_price') }} (<span class="name_retail_unit text-muted">
                                {{ $data->retail_units->name }}</span>) :</label>
                        <td> {{ $data->retail_half_Wholesale_price / 100}} </td>
                    </div>
                </div>

                <div class="row mb-2">

                    <div
                        class="form-group col-sm-6 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - {{ __('items.part_price') }} (<span
                                class="name_retail_unit text-muted">{{ $data->retail_units->name }}</span>)
                            :</label>
                        <td> {{ $data->retail_price / 100}} </td>
                    </div>

                    <div
                        class="form-group col-sm-6 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - {{ __('items.cost_price') }} (<span
                                class="name_retail_unit text-muted">{{ $data->retail_units->name }}</span>)
                            :</label>
                        <td> {{ $data->retail_cost_price/ 100 }} </td>
                    </div>
                </div>
@endif
                <div class="row mb-2">

                    <div class="form-group col-sm-6 ">
                        <label> - {{ __('items.const_price') }} :</label>
                        <td>
                            @if ($data->has_fixed_price == 1)
                            {{ __('items.constant_price') }}
                            @elseif($data->has_fixed_price == 0)
                            {{ __('items.can_change_price') }}
                            @endif
                        </td>
                    </div>

                    <div class="form-group col-sm-6">
                        <label> - {{ __('items.status') }} :</label>
                        <td>
                            @if ($data->active == 1)
                            {{ __('items.active') }}
                            @elseif($data->active == 0)
                            {{ __('items.inactive') }}
                            @endif
                        </td>
                    </div>

                </div>

                <div class="row mb-2">

                    <div class="form-group col-sm-8 ml-5">
                        <label> - {{ __('items.image') }} : </label>
                        <td>
                            @if (!empty($data->photo))
                                <img id="img" src="{{ asset('assets/admin/uploads/' . $data->photo) }}"
                                    alt="Item Photo" width="200" class="m-4">
                            @endif
                        </td>
                    </div>
                </div>


            </div>


            <a href="{{ route('itemcard.index') }}" class="btn btn-secondary m-4 p-2 col-sm-11">
                {{ __('items.cancel') }}
            </a>

        </div>

    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#delete_image').click(function() {
                $('#img').hide();
                $('#delete_photo').val('1');
            });

            $('#retail_options').change(function() {

                if ($(this).val() == 1) {
                    $('.retail_divs').css('display', 'block');
                } else {
                    $('.retail_divs').css('display', 'none');
                }

            });

            $('#retail_unit_id').change(function() {

                let text = $(this).find('option:selected').text();
                $('.name_retail_unit').text(text);

            });

        });
    </script>
@endsection
