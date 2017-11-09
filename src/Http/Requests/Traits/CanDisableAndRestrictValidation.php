<?php

namespace Acacha\Relationships\Http\Requests\Traits;

/**
 * Class DisableValidation
 *
 * @package Acacha\Relationships\Http\Requests\Traits
 */
trait CanDisableAndRestrictValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->disable_validation) return [];
        elseif ($this->strict_validation) return $this->strictRules;
        return $this->rules;
    }
}