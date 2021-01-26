<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use App\Rules\ZipCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            'name' => 'string|required',
            'email' => 'email|required',
            'phone' => ['string','required', new PhoneRule],
            'zip_code' => ['required', 'string', new ZipCodeRule],
        ];
    }
}
