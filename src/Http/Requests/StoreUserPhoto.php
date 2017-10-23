<?php

namespace Acacha\Relationships\Http\Requests;

use Acacha\Relationships\Http\Requests\Traits\UserOwns;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StorePhoto.
 *
 * @package Acacha\Relationships\Http\Requests
 */
class StoreUserPhoto extends FormRequest
{
    use UserOwns;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('store-person-photo')) return true;
        if ($this->owns()) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:16384',
        ];
    }

}
