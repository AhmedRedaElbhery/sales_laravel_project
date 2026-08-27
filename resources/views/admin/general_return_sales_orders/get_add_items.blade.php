@foreach ($bill_details as $data)
    <tr>

        {{-- <input type="hidden" class="general_return_sales_orders_item_total_price" name="item_total_price" value="{{ $data->total_price }}"> --}}
        <input type="hidden" id="general_return_sales_orders_delete_item_url" value="{{ route('general_return_sales_order.delete_item') }}">


        <input type="hidden" class="item_record_id" id="item_record_id" value="{{ $data->id }}">
        <input type="hidden" class="is_perent_unit" id="is_perent_unit" value="{{ $data->isparentunit }}">


        <td>{{ $data['item_name'] }}</td>
        <td>{{ $data['unit_name'] }}</td>
        <td>{{ $data['production_date'] }}</td>
        <td>{{ $data['end_date'] }}</td>
        <td>{{ $data['sale_type_name'] }}</td>
        <td>{{ $data->quantity * 1}}</td>
        <td>{{ $data->unit_price / 100 }}</td>
        <td class="general_return_sales_orders_item_total_price">{{ $data->total_price / 100 }}</td>

        @if ($is_approved == 0)
            <td>
                <button class="btn btn-danger" id="general_return_sales_orders_delete"> {{ __('returnSalesBills.delete') }}</button>
            </td>
        @endif

    </tr>
@endforeach
