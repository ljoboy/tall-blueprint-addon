<?php


namespace Tanthammar\TallBlueprintAddon\Tasks;


use Closure;
use Tanthammar\TallBlueprintAddon\Contracts\Task;

class OnUpdate implements Task
{
    const INDENT = '            ';

    public function handle(array $data, Closure $next): array
    {
        // TODO: Implement handle() method.
        return $next($data);
    }
}