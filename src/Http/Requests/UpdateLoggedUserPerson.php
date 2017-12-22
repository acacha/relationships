<?php

namespace Acacha\Relationships\Http\Requests;

use Acacha\Relationships\Http\Requests\Traits\UserPersonOwns;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateLoggedUserPerson.
 *
 * @package Acacha\Relationships\Http\Requests
 */
class UpdateLoggedUserPerson extends FormRequest
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
            //
        ];
    }
}