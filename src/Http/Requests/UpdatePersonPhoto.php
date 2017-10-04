<?php

namespace Acacha\Relationships\Http\Requests;

use Acacha\Relationships\Http\Requests\Traits\CheckPhotoIsOwnedByUser;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdatePersonPhoto.
 *
 * @package Acacha\Relationships\Http\Requests
 */
class UpdatePersonPhoto extends FormRequest
{
    use CheckPhotoIsOwnedByUser;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('update-person-photo')) return true;
        if ($this->isPhotoOwnedByUser()) return true;
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
