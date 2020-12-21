<?php

namespace MrMadClown\LaravelUtilities\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class XOrRule implements Rule
{
    public function __construct(private Rule $either, private Rule $or)
    {
    }

    public function passes($attribute, $value): bool
    {
        return $this->either->passes($attribute, $value) xor $this->or->passes($attribute, $value);
    }

    public function message(): array
    {
        return [
            $this->either->message(),
            $this->or->message(),
        ];
    }
}
