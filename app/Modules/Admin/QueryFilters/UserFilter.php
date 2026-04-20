<?php

namespace App\Modules\Admin\QueryFilters;

use App\Modules\Shared\QueryFilters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends BaseFilter
{
    public function role(Builder $query, $value)
    {
        return $query->where('role', $value);
    }

    public function active(Builder $query, $value)
    {
        return $query->where('active', $value);
    }

    public function sort(Builder $query, $value)
    {
        return $query->orderBy('created_at', $value);
    }
}
