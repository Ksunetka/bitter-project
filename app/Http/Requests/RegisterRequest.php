<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'regex:/^\S*$/u'],
            'last_name' => ['required', 'regex:/^\S*$/u'],
            'username' => ['required', 'regex:/^([a-z])+?(.|_)([a-z])+$/i', 'unique:users'],
            'gender' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ];
    }

    public function messages() {
        return [
            'first_name.required' => 'Вы не ввели имя',
            'first_name.regex' => 'Поле должно содержать только буквы',
            'last_name.required' => 'Вы не ввели фамилию',
            'last_name.regex' => 'Поле должна содержать только буквы',
            'username.required' => 'Вы не ввели Имя пользователя',
            'username.regex' => 'Имя пользователя введено неверно. Пример: user.name или user_name',
            'username.unique' => 'Такое имя уже существует',
            'gender.required' => 'Вы не указали пол',
            'email.required' => 'Вы не ввели email',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Такой email уже существует',
            'password.required' => 'Вы не ввели пароль',
            'password.min:8' => 'Пароль должен содержать не менее 8 символов',
            'password.confirmed' => 'Подтверждение пароля не совпадает',
        ];
    }
}
