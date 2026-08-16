@extends('layouts.admin')

@section('title')
    {{ __('items.edit_item') }}
@endsection

@section('contentheader')
{{ __('items.edit_item') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('itemcard.index') }}"> {{ __('items.items') }} </a>
@endsection

@section('contentheaderactive')
{{ __('items.edit_item') }}
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">{{ __('items.edit_item') }}</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('itemcard.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div>
                    <div class="row mb-2">
                        <div class="form-group col-sm-6">
                            <label>{{ __('items.barcode_item') }} <span class="text-muted">({{ __('items.auto_barcode') }}) </span>
                            </label>
                            <input type="text" name="barcode" class="form-control" value="{{ $data->barcode }}">
                            @error('barcode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('items.name') }} </label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-2">

                        <div class="form-group col-sm-3">
                            <label>{{ __('items.type') }} </label>
                            <select disabled name="item_type" class="form-control">

                                <option value="" disabled>{{ __('items.choose_type') }} </option>

                                @if ($data->item_type == 1)
                                    <option value="1" selected>{{ __('items.stock_item') }} </option>
                                    <option value="2"> {{ __('items.consumable_expiry') }}</option>
                                    <option value="3">{{ __('items.asset_item') }}</option>
                                @elseif ($data->item_type == 2)
                                    <option value="1">{{ __('items.stock_item') }}  </option>
                                    <option value="2" selected> {{ __('items.consumable_expiry') }}</option>
                                    <option value="3">{{ __('items.asset_item') }}</option>
                                @elseif($data->item_type == 3)
                                    <option value="1">{{ __('items.stock_item') }}  </option>
                                    <option value="2"> {{ __('items.consumable_expiry') }}</option>
                                    <option value="3" selected>{{ __('items.asset_item') }}</option>
                                @endif

                            </select>
                            @error('item_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-3">
                            <label>{{ __('items.category') }} </label>
                            <select disabled name="category_id" class="form-control">
                                <option value="" selected disabled>{{ __('items.choose_category') }} </option>

                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" @if ($data->categories_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-3">
                            <label>{{ __('items.the_main_item') }} </label>
                            <select disabled name="parent_id" class="form-control">
                                <option value="0"> {{ __('items.main_item') }} </option>

                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}" @if ($data->parent_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-3">
                            <label> {{ __('items.main_unit_of_item') }} </label>
                            <select disabled name="unit_parent_id" id="unit_parent_id" class="form-control">
                                <option value="" disabled> {{ __('items.choose_unit') }} </option>

                                @foreach ($units as $item)
                                    <option value="{{ $item->id }}" @if ($data->parent_unit_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_parent_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-2">


                        <div class="form-group col-sm-3">
                            @php
                                $unitName = $units->where('id', $data->parent_unit_id)->first()?->name;
                            @endphp
                            <label>{{ __('items.whole_price') }}  (<span class="text-muted name_parent_unit">{{ $unitName }}
                                </span>) </label>
                            <input type="text" name="Wholesale_price" class="form-control"
                                value="{{ $data->Wholesale_price / 100 }}">
                            @error('Wholesale_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-3 ">
                            <label>{{ __('items.part_whole_price') }}  (<span class="name_parent_unit text-muted">
                                    {{ $unitName }}</span>) </label>
                            <input type="text" name="half_Wholesale_price" class="form-control"
                                value="{{ $data->half_Wholesale_price / 100 }}">
                            @error('half_Wholesale_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-3">
                            <label>{{ __('items.part_price') }}  (<span class="name_parent_unit text-muted">{{ $unitName }} </span>)
                            </label>
                            <input type="text" name="price" class="form-control" value="{{ $data->price/ 100 }}">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-3">
                            <label>{{ __('items.cost_price') }}  (<span class="name_parent_unit text-muted">{{ $unitName }}
                                </span>)</label>
                            <input type="text" name="cost_price" class="form-control" value="{{ $data->cost_price/ 100 }}">
                            @error('cost_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group col-5">
                        <label>{{ __('items.has_retail_unit') }}</label>
                        <select @if ($data->has_retail_unit == 1) disabled @endif name="has_retail_unit" id="retail_options" class="form-control">
                            <option value="" selected disabled>{{ __('items.choose_type') }} </option>
                            <option value="1" @if ($data->has_retail_unit == 1) selected @endif>{{ __('items.yes') }} </option>
                            <option value="0" @if ($data->has_retail_unit == 0) selected @endif> {{ __('items.no') }}</option>
                        </select>
                        @error('has_retail_unit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-4 retail_divs"
                            @if ($data->has_retail_unit != '1') style="display:none" @endif>
                            <label>{{ __('items.the_retail_unit') }}  </label>
                            <select  @if ($data->has_retail_unit == 1) disabled @endif id="retail_unit_id" name="retail_units" class="form-control">
                                <option value="" disabled @if ($data->retail_unit_id == null) selected @endif>
                                    {{ __('items.choose_unit') }} </option>

                                @foreach ($retail_units as $item)
                                    <option value="{{ $item->id }}"@if ($data->retail_unit_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('retail_units')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-4 retail_divs"
                            @if ($data->has_retail_unit != '1') style="display:none" @endif>
                            @php
                                $retailName = $retail_units->where('id', $data->retail_unit_id)->first()?->name;
                            @endphp
                            <label> {{ __('items.retail_unit_number') }}  (<span
                                    class="name_retail_unit text-muted ">{{ $retailName }} </span>) لل (<span
                                    class="name_parent_unit text-muted ">{{ $unitName }} </span>)
                            </label>
                            <input type="text" name="retail_unit_to_parent" class="form-control"
                                value="{{ $data->retail_unit_to_parent }}">
                            @error('retail_unit_to_parent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-4 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                            <label>{{ __('items.whole_price') }} (<span class="name_retail_unit text-muted">
                                    {{ $retailName }}</span>)</label>
                            <input type="text" name="retail_Wholesale_price" class="form-control"
                                value="{{ $data->retail_Wholesale_price / 100 }}">
                            @error('retail_Wholesale_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div
                            class="form-group col-sm-4 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                            <label>{{ __('items.part_whole_price') }} (<span class="name_retail_unit text-muted">
                                    {{ $retailName }}</span>)</label>
                            <input type="text" name="retail_half_Wholesale_price" class="form-control"
                                value="{{ $data->retail_half_Wholesale_price/ 100 }}">
                            @error('retail_half_Wholesale_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-4 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                            <label>{{ __('items.part_price') }} (<span
                                    class="name_retail_unit text-muted">{{ $retailName }}</span>)</label>
                            <input type="text" name="retail_price" class="form-control"
                                value="{{ $data->retail_price/ 100 }}">
                            @error('retail_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-4 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                            <label>{{ __('items.cost_price') }} (<span
                                    class="name_retail_unit text-muted">{{ $retailName }}</span>)</label>
                            <input type="text" name="retail_cost_price" class="form-control"
                                value="{{ $data->retail_cost_price/ 100 }}">
                            @error('retail_cost_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-4 ">
                            <label> {{ __('items.const_price') }} </label>
                            <select name="has_fixed_price" class="form-control">
                                <option value="" selected disabled>{{ __('items.choose_status') }}</option>
                                <option value="1" @if ($data->has_fixed_price == 1) selected @endif>{{ __('items.constant_price') }}</option>
                                <option value="0" @if ($data->has_fixed_price == 0) selected @endif> {{ __('items.can_change_price') }}</option>
                            </select>
                            @error('has_fixed_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">


                        <div class="form-group col-sm-5">
                            <label>{{ __('items.status') }}</label>
                            <select name="active" class="form-control">
                                <option value="" selected disabled>{{ __('items.choose_status') }}</option>
                                <option value="1" @if ($data->active == 1) selected @endif>{{ __('items.active') }}</option>
                                <option value="0" @if ($data->active == 0) selected @endif>{{ __('items.inactive') }}</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6 ml-5">
                            <label>{{ __('items.image') }} </label>
                            <div class="d-flex align-items-center">

                                <input type="file" name="photo" class="form-control">
                                <input type="hidden" name="delete_photo" id="delete_photo" value="">

                                @if (!empty($data->photo))
                                    <img id="img" src="{{ asset('assets/admin/uploads/' . $data->photo) }}"
                                        alt="Item Photo" width="150" class="m-2">
                                @endif
                            </div>

                            <a id="delete_image" class="btn btn-sm btn-danger text-white mt-2">{{ __('items.delete_image') }} </a>
                            @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    {{ __('items.save') }}
                </button>

                <a href="{{ route('itemcard.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    {{ __('items.cancel') }}
                </a>

            </form>

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
