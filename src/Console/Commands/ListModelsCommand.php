<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 22.04.20
 */

namespace MrMadClown\LaravelUtilities\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ListModelsCommand extends Command
{
    /** @var string */
    protected $signature = 'app:list {model} {filter?*}';

    /**  @var string */
    protected $description = 'Lists all Models of given class';

    public function handle(): void
    {
        $model = $this->argument('model');

//        $classes = [
//            Feed::class,
//            Element::class,
//            FeedSchedule::class,
//            Platform::class,
//        ];
//
//        $class = collect($classes)->first(static function (string $class) use ($model): bool {
//            return Str::lower(class_basename($class)) === $model;
//        });

        $class = Relation::getMorphedModel($model);

        if (!$class) {
            $this->error("There is no model ${model} registered!");

            return;
        }
        /** @var Builder $modelQuery */
        $modelQuery = $class::query();
        if ($this->hasArgument('filter')) {
            collect($this->argument('filter'))
                ->each(static function (string $filter) use ($modelQuery) {
                    \preg_match('/^(\b\w+\b):([\*|>|<]?)(\b\w+\b)$/', $filter, $matches);
                    [$fullMatch, $field, $operator, $value] = $matches;
                    if ($operator === '*') $operator = 'CONTAINS';
                    $modelQuery->where($field, ($operator ?? '='), $value);
                });
        }

        $models = $modelQuery->get();

        if ($models->isEmpty()) {
            $this->info("There are no ${model}'s in the Database");

            return;
        }
        $this->table(\array_keys($models->first()->getAttributes()), $models->map->getAttributes());
    }
}
