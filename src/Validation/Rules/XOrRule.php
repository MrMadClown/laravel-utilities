<?php

namespace MrMadClown\LaravelUtilities\Validation\Rules;

class XOrRule extends OrRule
{
    public function passes($attribute, $value): bool
    {
        return $this->either->passes($attribute, $value) xor $this->or->passes($attribute, $value);
    }
}
