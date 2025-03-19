<tr>
    <td><input type="checkbox" class="adminPanelCheckbox" name="order_ids[]" value="{{ $order->order_id }}"></td>
    <td style="padding-left: 40px;">{{ $order->order_id }}</td>
    <td>{{ $order->customer_name }}</td>
    <td>{{ $order->phone }}</td>
    <td>{{ $order->created_at }}</td>
    <td>{{ $order->product_names ?? 'Нет данных' }}</td>
    <td>{{ $order->total_count ?? '0' }}</td>
    <td>{{ ($order->product_price * 0.9) * $order->total_count }}</td>
    <td>{{ $order->terms ? 'Да' : 'Нет' }}</td>

</tr>


