<?php

namespace Demo\RequestValidation;

use Demo\Rules\Rules;

class FormValidation
{
    protected $validated = false;

    protected $validatedObject = [];
    protected Rules $rules;

    public function __construct(Rules $rules)
    {
        $this->rules = $rules;
    }

    public function rules($rules)
    {
        $this->rules->rules($rules);
    }

    public function validate()
    {
        $this->validatedObject = $this->rules->getValidatedRules();

        $this->validated = true;

        foreach ($this->validatedObject as $name => $records) {
            foreach ($records as $record) {
                if ($record[0] === false) {
                    $this->validated = false;
                }
            }
        }

        return $this->validatedObject;
    }

    public function validated()
    {
        return $this->validated;
    }
}
