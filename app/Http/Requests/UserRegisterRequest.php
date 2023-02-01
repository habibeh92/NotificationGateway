<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email"    => "required|email|unique:users,email",
            "username" => "required|unique:users,username",
            "name"     => "required",
            "password" => "required|confirmed|min:6",
            "mobile"   => "required|unique:users,mobile",
        ];
    }
}
