
    <div class="form-group">
        <label>بيانات وحدات الاصناف </label>
        <select id="unit_id_add" name="units" class="form-control select2">
            <option value="" selected disabled>اختر الوحده</option>

            @if (isset($data) && $data != null)

                @if ($data['has_retail_unit'] == 1)

                    <option data-isparentunit="1" value="{{ $data->parent_unit_id }}">
                        {{ $data->parent_unit_name }} (وحده اساسى)</option>

                    <option data-isparentunit="0" value="{{ $data->retail_unit_id }}"> {{ $data->retail_unit_name }} (وحده تجزئه)</option>
                @else
                <option data-isparentunit="1" value="{{ $data->parent_unit_id }}">
                    {{ $data->parent_unit_name }} (وحده اساسى)</option>
                @endif
            @endif

        </select>

        @error('unit_id_add')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

