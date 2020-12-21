<?php

namespace MrMadClown\LaravelUtilities\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class RecursiveRule implements Rule
{
    public function __construct(private Rule $rule)
    {
    }

    public function passes($attribute, $value): bool
    {
        return $this->checkValue($attribute, $value);
    }

    public function message(): string
    {
        return $this->rule->message();
    }

    protected function checkValue(string|int $key, mixed $value): bool
    {
        return is_array($value)
            ? $this->walkValue($value)
            : $this->rule->passes($key, $value);
    }

    protected function walkValue(array $values): bool
    {
        $result = true;
        foreach ($values as $key => $value) {
            $result &= $this->checkValue($key, $value);
        }

        return $result;
    }
}
