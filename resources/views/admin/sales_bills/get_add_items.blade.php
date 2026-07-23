@foreach ($bill_details as $data)
    <tr>

        <input type="hidden" class="item_total_price" name="item_total_price" value="{{ $data->total_price }}">
        <input type="hidden" id="sales_delete_item_url" value="{{ route('sales_item.delete_item') }}">


        <input type="hidden" class="item_record_id" id="item_record_id" value="{{ $data->id }}">
        <input type="hidden" class="is_perent_unit" id="is_perent_unit" value="{{ $data->isparentunit }}">


        <td>{{ $data['item_name'] }}</td>
        <td>{{ $data['unit_name'] }}</td>
        <td>{{ $data['normal_sale_name'] }}</td>
        <td>{{ $data->quantity }}</td>
        <td>{{ $data['sale_type_name'] }}</td>
        <td>{{ $data->unit_price / 100 }}</td>
        <td>{{ $data->total_price / 100 }}</td>
        <td>
            <button class="btn btn-danger" id="delete">حذف</button>
        </td>
    </tr @endforeach
