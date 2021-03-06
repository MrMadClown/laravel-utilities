<?php

namespace MrMadClown\LaravelUtilities\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class OrRule implements Rule
{
    public function __construct(protected Rule $either, protected Rule $or)
    {
    }

    public function passes($attribute, $value): bool
    {
        return $this->either->passes($attribute, $value) or $this->or->passes($attribute, $value);
    }

    public function message(): array
    {
        return [
            $this->either->message(),
            $this->or->message(),
        ];
    }
}
