<div class="form-group">
    <label>بيانات الكميات </label>
    <select id="quantity_with_date" name="quantity_with_date" class="form-control">


        <option value="" selected disabled>اختر المناسب</option>
            @foreach ($batches_data as $data)
                <option value="{{ $data->id }}"> الكميه المتاحه {{ $data->quantity * 1 }} @if ( $data->production_date != null)
                    بتاريخ
                    {{ $data->production_date }}
                @endif</option>
            @endforeach
    </select>

    @error('quantity_with_date')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
