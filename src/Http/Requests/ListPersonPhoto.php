<?php

namespace Acacha\Relationships\Http\Requests;

use Acacha\Relationships\Http\Requests\Traits\PersonOwns;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ListPersonPhoto.
 *
 * @package Acacha\Relationships\Http\Requests
 */
class ListPersonPhoto extends FormRequest
{

    use PersonOwns;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('list-person-photos')) return true;
        if ($this->personOwns()) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

}
