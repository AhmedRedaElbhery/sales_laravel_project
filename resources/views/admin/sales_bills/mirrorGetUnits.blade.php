<div class="form-group">

    <label>{{ __('salesBills.item_units') }}</label>

    <select id="mirror_unit_id_add" name="units" class="form-control">

        <option value="" selected disabled>
            {{ __('salesBills.choose_unit') }}
        </option>


        @if (isset($data) && $data != null)

            @if ($data['has_retail_unit'] == 1)

                <option data-isparentunit="1" value="{{ $data->parent_unit_id }}">

                    {{ $data->parent_unit_name }}
                    ({{ __('salesBills.basic_unit') }})

                </option>


                <option data-isparentunit="0" value="{{ $data->retail_unit_id }}">

                    {{ $data->retail_unit_name }}
                    ({{ __('salesBills.retail_unit') }})

                </option>


            @else

                <option data-isparentunit="1" value="{{ $data->parent_unit_id }}">

                    {{ $data->parent_unit_name }}
                    ({{ __('salesBills.basic_unit') }})

                </option>

            @endif

        @endif


    </select>


    @error('unit_id_add')
        <span class="text-danger">{{ $message }}</span>
    @enderror

</div>