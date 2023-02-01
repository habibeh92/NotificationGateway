<?php

namespace App\Http\Requests;

use App\NotificationDrivers\GhasedakDriver;
use App\NotificationDrivers\KavenegarDriver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * @property string|array receptor
 * @property string       message
 * @property string       driver
 */
class NotificationSendRequest extends FormRequest
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
     * validaton rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            "receptor" => ["required", "numeric", $this->validateReceptor()],
            "message"  => "required",
            "driver"   => Rule::in([KavenegarDriver::index(), GhasedakDriver::index()]),
        ];

    }



    /**
     * validate the receptor mobile number
     *
     * @return string
     */
    private function validateReceptor(): string
    {
        if (!Str::startsWith($this->receptor, "09")) {
            return "invalid";
        }
        if (strlen($this->receptor) != 11) {
            return "invalid";
        }

        return "";
    }

}
