<div class="form-group">
    <label>بيانات الكميات </label>
    <select id="quantity_with_date" name="quantity_with_date" class="form-control">


        @if (isset($batches_data) && $batches_data != null)
        <option value="" selected disabled>اختر المناسب</option>
            @foreach ($batches_data as $data)
                <option value="{{ $data->id }}"> الكميه المتاحه {{ $data->quantity * 1 }} بتاريخ
                    {{ $data->production_date }}</option>
            @endforeach
        @else
            <option value="0" selected disabled>الكميه المتاحه بالمخزن {{ $total_quantity *1 }}</option>
        @endif

    </select>

    @error('quantity_with_date')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
