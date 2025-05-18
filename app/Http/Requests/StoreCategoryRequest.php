<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Разрешить выполнение запроса
    }

    public function rules(): array
    {
        return [
            'categories_name' => 'required|string|max:255',
            'categories_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'categories_name.required' => 'Пожалуйста, укажите наименование категории.',
            'categories_img.required' => 'Пожалуйста, загрузите изображение категории.',
            'categories_img.image' => 'Файл должен быть изображением.',
            'categories_img.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif.',
            'categories_img.max' => 'Размер изображения не должен превышать 2MB.',
        ];
    }
}
