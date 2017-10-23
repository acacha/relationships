<?php

namespace Acacha\Relationships\Http\Requests;

use Acacha\Relationships\Http\Requests\Traits\PersonOwns;
use Auth;
use Illuminate\Foundation\Http\FormRequest;


/**
 * Class PutPhotoRequest.
 *
 * @package Acacha\Relationships\Http\Requests
 */
class PostPhotoRequest extends FormRequest
{
    use PersonOwns;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('post-photos')) return true;
        if ($this->personOwns($this->photo->person_id)) return true;
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