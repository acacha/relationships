<?php

namespace Acacha\Relationships\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateLoggedUserEmail.
 *
 * @package Acacha\Relationships\Http\Requests
 */
class UpdateLoggedUserEmail extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (count($this->mail->persons) === 0) return false;
        if (! Auth::user()->person ) return false;
        if (!in_array(Auth::user()->person->id,$this->mail->persons->pluck('id')->toArray())) return false;
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
            'email'    => 'required|email|max:255',
        ];
    }
}