<tr>
    <td>
        <input type="checkbox" class="adminPanelCheckbox" name="product_ids[]" value="{{ $product->id }}">
    </td>
    <td>
        <img
            src="{{ Vite::asset('public/img/catalog/' . ($product->main_image ?? 'default_image.jpg')) }}"
            alt="{{ $product->product_name }}"
        />
    </td>

    <td>
        <a href="{{ route('cartProduct', ['id' => $product->id]) }}">{{ $product->product_name }}</a>
    </td>
    <td>{{ $product->product_price }}</td>
    <td>
        <span class="adminPanelStatusBadge {{ $product->availability ? 'success' : 'error' }}">
            {{ $product->availability ? 'В наличии' : 'Нет в наличии' }}
        </span>
    </td>
    <td>{{ $product->product_memory ? $product->product_memory . ' Гб' : '-' }}</td>
    <td style="padding-left: 70px">{{ $product->categories_id}}</td>
    <td>
        <a href="{{ route('adminPanelProductCard', ['id' => $product->id]) }}" class="adminPanelActionBtn">Редактировать</a>
    </td>
</tr>
