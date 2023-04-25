<?php

namespace App\Http\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class UsersFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->select('users.*')
            ->where('username', 'LIKE', "%{$value}%")
            ->orWhere('email', 'LIKE', "%{$value}%")
            ->orWhere('phone', 'LIKE', "%{$value}%");
    }
}