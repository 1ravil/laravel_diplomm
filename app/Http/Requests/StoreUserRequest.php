<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'role' => 'required|integer|in:1,2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',

            'role.required' => 'Роль обязательна.',
            'role.integer' => 'Роль должна быть числом.',
            'role.in' => 'Роль должна быть 1 (пользователь) или 2 (админ).',

            'email.required' => 'Email обязателен.',
            'email.email' => 'Email должен быть корректным адресом.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'email.unique' => 'Пользователь с таким email уже существует.',

            'password.required' => 'Пароль обязателен.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
        ];
    }

}
