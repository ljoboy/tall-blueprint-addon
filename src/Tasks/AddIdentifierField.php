<?php

namespace Naoray\BlueprintNovaAddon\Tasks;

use Closure;
use Blueprint\Models\Model;
use Illuminate\Support\Arr;
use Blueprint\Models\Column;

class AddIdentifierField
{
    const INDENT = '            ';

    public function handle($data, Closure $next): array
    {
        /** @var Model */
        $model = $data['model'];

        $column = $this->getIdentifierColumn(
            $model->columns(),
            $model->relationships()
        );

        $identifierName = $column->name() === 'id' ? '' : "'" . $column->name() . "'";
        $data['fields'] .= 'ID::make(' . $identifierName . ')->sortable(),' . PHP_EOL . PHP_EOL;
        $data['imports'][] = 'ID';

        return $next($data);
    }

    private function getIdentifierColumn(array $columns, array $relations): Column
    {
        $name = collect($columns)
            ->filter(function (Column $column) {
                return $column->dataType() === 'id';
            })
            ->map(function (Column $column) {
                return empty($column->attributes())
                    ? $column->name()
                    : implode(':', $column->attributes()) . ":{$column->name()}";
            })->values()
            ->diff(Arr::get($relations, 'belongsTo', []))
            ->first();

        return $columns[$name];
    }
}