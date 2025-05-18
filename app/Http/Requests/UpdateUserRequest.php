<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'role' => ['required', 'integer', Rule::in([1, 2])],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('id')),
            ],
            'password' => 'nullable|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно для заполнения.',
            'role.required' => 'Роль обязательна для заполнения.',
            'role.integer' => 'Роль должна быть числом.',
            'role.in' => 'Роль должна быть 1 (пользователь) или 2 (админ).',
            'email.required' => 'Электронная почта обязательна.',
            'email.email' => 'Поле должно содержать корректный email.',
            'email.unique' => 'Этот email уже используется.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Имя',
            'role' => 'Роль',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
        ];
    }
}

