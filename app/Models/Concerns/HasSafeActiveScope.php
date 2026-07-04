<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait HasSafeActiveScope
{
    protected static array $columnExistsCache = [];

    private function hasColumnCached(string $table, string $column): bool
    {
        $cacheKey = $table.'.'.$column;

        if (!array_key_exists($cacheKey, self::$columnExistsCache)) {
            self::$columnExistsCache[$cacheKey] =
                Schema::hasTable($table) && Schema::hasColumn($table, $column);
        }

        return self::$columnExistsCache[$cacheKey];
    }

    public function scopeActive(Builder $query): Builder
    {
        $table = $this->getTable();

        if (!$this->hasColumnCached($table, 'is_active')) {
            return $query;
        }

        return $query->where($table.'.is_active', true);
    }

    public function scopeOrdered(Builder $query, string $direction = 'asc', string $fallbackColumn = 'id'): Builder
    {
        $table = $this->getTable();

        if ($this->hasColumnCached($table, 'sort_order')) {
            return $query->orderBy($table.'.sort_order', $direction);
        }

        if ($fallbackColumn !== '' && $this->hasColumnCached($table, $fallbackColumn)) {
            return $query->orderBy($table.'.'.$fallbackColumn, $direction);
        }

        return $query;
    }
}