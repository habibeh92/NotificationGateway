<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string username
 * @property string password
 */
class UserLoginRequest extends FormRequest
{

    /**
     * @inheritdoc
     */
    public function fillableFields()
    {
        return [
            "username",
            "password",
        ];
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "username" => "required",
            "password" => "required",
        ];
    }
}
