<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Race extends Model
{
    protected $table = 'race';

    /**
     * Scope to filter by race id
     * @param Builder $query
     * @param Int $raceId
     * @return Builder $query
     */
    public function scopeFilterByRaceId(Builder $query, Int $raceId) : Builder
    {
        $query->where('id', $raceId);

        return $query;
    }

    /**
     * Scope to filter by date
     * @param Builder $query
     * @param String $date
     * @return Builder $query
     */
    public function scopeFilterByDate(Builder $query, String $date) : Builder
    {
        $query->where('date', $date);

        return $query;
    }
}
