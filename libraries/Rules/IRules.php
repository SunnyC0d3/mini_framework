<?php

namespace Demo\Rules;

interface IRules
{
    public function rules($rules);

    public function getValidatedRules();
}
