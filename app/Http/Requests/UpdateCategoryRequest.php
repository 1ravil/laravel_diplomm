<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categories_name' => 'required|string|max:255',
            'product_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'categories_name.required' => 'Поле "Наименование категории" обязательно.',
            'categories_name.max' => 'Название не должно превышать 255 символов.',
            'product_img.image' => 'Файл должен быть изображением.',
            'product_img.mimes' => 'Допустимые форматы изображения: jpeg, png, jpg, gif.',
            'product_img.max' => 'Изображение не должно превышать 2 МБ.',
        ];
    }
}
