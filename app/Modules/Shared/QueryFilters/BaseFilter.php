<?php

namespace App\Modules\Shared\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BaseFilter
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query): Builder
    {
        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name) && $value !== null) {
                $query = $this->$name($query, $value);
            }
        }
        return $query;
    }

    public function filters(): array
    {
        return $this->request->all();
    }
}
