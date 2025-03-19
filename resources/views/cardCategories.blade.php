<div class="categories_container">
    <div class="categories_card">
        <div class="category_img">
            <img
                src="{{ Vite::asset('resources/img/categories/' . $categories1->img) }}"
                alt="categories" class="imgCategories"
            />
        </div>
        <div class="category-name">
            <a href="/catalog/{{$categories1->id}}">
            {{ $categories1->name }}
        </div>
    </div>
</div>
