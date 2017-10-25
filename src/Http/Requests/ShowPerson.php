<?php

namespace Acacha\Relationships\Http\Requests;

use Acacha\Relationships\Http\Requests\Traits\UserPersonOwns;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShowPerson.
 *
 * @package Acacha\Relationships\Http\Requests
 */
class ShowPerson extends FormRequest
{
    use UserPersonOwns;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('show-person')) return true;
        if ($this->UserPersonOwns()) return true;
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
            //
        ];
    }
}