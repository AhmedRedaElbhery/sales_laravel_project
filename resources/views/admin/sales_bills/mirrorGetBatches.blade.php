<div class="form-group">

    <label>{{ __('salesBills.quantity_data') }}</label>

    <select id="mirror_quantity_with_date" name="mirror_quantity_with_date" class="form-control">

        <option value="" selected disabled>
            {{ __('salesBills.choose_suitable') }}
        </option>

        @foreach ($batches_data as $data)

            <option value="{{ $data->id }}">

                {{ __('salesBills.available_quantity') }}
                {{ $data->quantity * 1 }}

                @if ($data->production_date != null)

                    {{ __('salesBills.with_date') }}
                    {{ $data->production_date }}

                @endif

            </option>

        @endforeach

    </select>


    @error('quantity_with_date')
        <span class="text-danger">{{ $message }}</span>
    @enderror

</div>