<tr>
    <td><input type="checkbox" class="adminPanelCheckbox" name="category_ids[]" value="{{ $categories->id }}"></td>
    <td style="padding-left: 40px;">{{$categories->id}}</td>
    <td style="padding-left: 40px;"> <img
            src="{{ Vite::asset('resources/img/categories/' . $categories->img) }}"
            alt="img"
        />
    </td>
    </td>
    <td style="padding-left: 60px;">{{$categories->name}}</td>
    <td style="padding-left: 80px;">{{ \App\Models\Products::where('categories_id', $categories->id)->count() }} </td>
    <td>
        <a href="{{ route('CategoriesEdit', ['id' => $categories->id]) }}" class="adminPanelActionBtn">Редактировать</a>
    </td>

</tr>

