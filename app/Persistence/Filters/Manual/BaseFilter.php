<?php

declare(strict_types=1);

namespace App\Persistence\Filters\Manual;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter implements FilterInterface
{

    public function __construct(private array $queryParams)
    {
    }

    public function apply(Builder $builder): void
    {
        $this->before($builder);

        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->queryParams[$name])) {
                $params = $this->queryParams[$name];

                is_array($params) ? $callback($builder, ...$params)
                    : $callback($builder, $params);
            }
        }
    }

    protected function before(Builder $builder)
    {
        //
    }

    protected function getQueryParams(string $key, $default = null)
    {
        return $this->queryParams[$key] ?? $default;
    }

    protected function removeQueryParams(string ...$keys): void
    {
        foreach ($keys as $key) {
            unset($this->queryParams[$key]);
        }
    }

    abstract public function getCallbacks(): array;
}