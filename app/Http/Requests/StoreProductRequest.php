<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Можно добавить дополнительные проверки для прав доступа, если нужно
    }

    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_color' => 'required|string|max:100',
            'product_memory' => 'nullable|integer|min:0', // Сделать необязательным (nullable)
            'product_images' => 'required|array|min:4', // Минимум 4 изображения
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Максимальный размер 2MB для каждого изображения
            'categories_id' => 'required|integer|exists:categories,id',
            'product_description' => 'required|string',
            'availability' => 'nullable|boolean', // Сделать nullable для поля "наличие"
        ];
    }

    public function messages(): array
    {
        return [
            'product_name.required' => 'Введите наименование товара.',
            'product_price.required' => 'Введите цену товара.',
            'product_price.numeric' => 'Цена должна быть числом.',
            'product_price.min' => 'Цена не может быть меньше 0.',
            'product_color.required' => 'Введите цвет товара.',
            'product_memory.integer' => 'Память должна быть числом.',
            'product_memory.min' => 'Память не может быть меньше 0.',
            'product_images.required' => 'Пожалуйста, загрузите изображения товара.',
            'product_images.min' => 'Необходимо выбрать минимум 4 изображения.',
            'product_images.*.image' => 'Каждый файл должен быть изображением.',
            'product_images.*.mimes' => 'Файлы должны быть формата jpeg, png, jpg, gif или svg.',
            'product_images.*.max' => 'Размер каждого изображения не должен превышать 2MB.',
            'categories_id.required' => 'Пожалуйста, выберите категорию.',
            'categories_id.integer' => 'Категория должна быть числом.',
            'categories_id.exists' => 'Выбранная категория не существует.',
            'product_description.required' => 'Введите описание товара.',
            'availability.boolean' => 'Поле "В наличии" должно быть логическим значением (1 или 0).',
        ];
    }


}
