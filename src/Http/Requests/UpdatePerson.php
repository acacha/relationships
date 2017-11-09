<?php

namespace Acacha\Relationships\Http\Requests;

use Acacha\Relationships\Http\Requests\Traits\CanDisableAndRestrictValidation;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdatePerson.
 *
 * @package Acacha\Relationships\Http\Requests
 */
class UpdatePerson extends FormRequest
{

    use CanDisableAndRestrictValidation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('update-person')) return true;
        return false;
    }

    /**
     * Strict validation rules.
     *
     * @var array
     */
    protected $strictRules = [
        'givenName' => 'required|string',
        'surname1' => 'required|string',
        'identifier' => 'required',
        'identifier_type' => 'required',
        'birthdate' => 'required|date',
        // TODO birthdate have to be before now!
//        'last_date' => 'required|date_format:"Y-m-d"|before:first_date',
        'birthplace_id' => 'required|numeric',
        'gender' => 'required|in:male,female',
//        'state' => 'sometimes|in:draft,valid,complete',

        // TODO:
        //$table->enum('civil_status',['Soltero/a','Casado/a','Separado/a','Divorciado/a','Viudo/a'])->nullable();
        //$table->enum('state',['draft','valid','completed'])->default('draft');

    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'givenName' => 'required|string',
        'surname1' => 'required|string',
        'identifier' => 'required',
        'identifier_type' => 'required',
//        'surname2' => 'sometimes|required|string',
//        'birthdate' => 'sometimes|required|date',
//        'birthplace_id' => 'sometimes|required|date',
//        'gender' => 'sometimes|in:male,female',
//        'state' => 'sometimes|in:draft,valid,complete',
    ];
}
