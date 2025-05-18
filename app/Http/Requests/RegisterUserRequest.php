<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required','string','max:255'],
            'surname'  => ['required','string','max:255'],
            'email'    => ['required','string','email','max:255','unique:users,email'],
            'password' => [
                'required',
                'confirmed',                  // ждёт field password_confirmation
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // Имя
            'name.required'  => 'Поле «Имя» обязательно.',
            'name.string'    => 'Поле «Имя» должно быть строкой.',
            'name.max'       => 'Поле «Имя» не может превышать :max символов.',

            // Фамилия
            'surname.required' => 'Поле «Фамилия» обязательно.',
            'surname.string'   => 'Поле «Фамилия» должно быть строкой.',
            'surname.max'      => 'Поле «Фамилия» не может превышать :max символов.',

            // Email
            'email.required' => 'Поле «Почта» обязательно.',
            'email.string'   => 'Поле «Почта» должно быть строкой.',
            'email.email'    => 'Введите корректный адрес электронной почты.',
            'email.max'      => 'Поле «Почта» не может превышать :max символов.',
            'email.unique'   => 'Этот адрес электронной почты уже занят.',

            // Пароль
            'password.required'  => 'Поле «Пароль» обязательно.',
            'password.confirmed' => 'Пароли не совпадают.',

            'password.min'     => 'Пароль должен содержать не менее :min символов.',
            'password.letters' => 'Пароль должен содержать хотя бы одну букву.',
            'password.mixed'   => 'Пароль должен содержать буквы в верхнем и нижнем регистрах.',
            'password.numbers' => 'Пароль должен содержать хотя бы одну цифру.',
            'password.symbols' => 'Пароль должен содержать хотя бы один спецсимвол.',
        ];
    }


}
