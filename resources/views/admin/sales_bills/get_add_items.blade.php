<tr>

    <input type="hidden" class="item_total_price" name="item_total_price" value="{{  $data['total_price'] }}">


    <input type="hidden" class="store_id" name="store_id" value="{{  $data['store_id'] }}">
    <input type="hidden" class="item_code" name="item_code" value="{{  $data['item_code'] }}">
    <input type="hidden" class="parent_unit" name="parent_unit" value="{{  $data['parent_unit'] }}">
    <input type="hidden" class="unit_id" name="unit_id" value="{{  $data['unit_id'] }}">
    <input type="hidden" class="batche_id" name="batche_id" value="{{  $data['batche_id'] }}">
    <input type="hidden" class="sale_type" name="sale_type" value="{{  $data['sale_type'] }}">
    <input type="hidden" class="quantity" name="quantity" value="{{  $data['quantity'] }}">
    <input type="hidden" class="price" name="price" value="{{  $data['price'] }}">
    <input type="hidden" class="total_price" name="total_price" value="{{  $data['total_price'] }}">
    <input type="hidden" class="normal_sale" name="normal_sale" value="{{  $data['normal_sale'] }}">

    <td>{{ $data['item_name'] }}</td>
    <td>{{ $data['unit_name'] }}</td>
    <td>{{ $data['normal_sale_name'] }}</td>
    <td>{{ $data['quantity'] }}</td>
    <td>{{ $data['sale_type_name'] }}</td>
    <td>{{ $data['price'] }}</td>
    <td>{{ $data['total_price'] }}</td>
    <td>
        <button class="btn btn-danger delete">حذف</button>
    </td>
</tr