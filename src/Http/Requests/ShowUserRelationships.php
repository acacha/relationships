<?php

namespace Acacha\Relationships\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShowUserRelationships.
 *
 * @package App\Http\Requests
 */
class ShowUserRelationships extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('show-user-relationships')) return true;
        if ($this->route('user_id') == Auth::user()->id) return true;
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
