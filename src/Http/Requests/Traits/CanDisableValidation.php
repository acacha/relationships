<?php

namespace Acacha\Relationships\Http\Requests\Traits;

/**
 * Class DisableValidation
 *
 * @package Acacha\Relationships\Http\Requests\Traits
 */
trait CanDisableValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->disable_validation) return [];

        return $this->rules;
    }
}