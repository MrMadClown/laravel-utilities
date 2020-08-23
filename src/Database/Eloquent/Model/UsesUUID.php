<?php

namespace MrMadClown\LaravelUtilities\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UsesUUID
{
    protected static function bootUsesUUID(): void
    {
        static::creating(static function (Model $model): void {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    /** @codeCoverageIgnore */
    public function getKeyType()
    {
        return 'string';
    }
}
