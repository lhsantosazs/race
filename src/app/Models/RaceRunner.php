<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RaceRunner extends Model
{
    protected $table = 'race_runner';

    /**
     * Scope to filter by runner id
     * @param Builder $query
     * @param Int $runnerId
     * @return Builder $query
     */
    public function scopeFilterByRunnerId(Builder $query, Int $runnerId) : Builder
    {
        $query->where('runner_id', $runnerId);

        return $query;
    }

    /**
     * Scope to filter by race id
     * @param Builder $query
     * @param Int $raceId
     * @return Builder $query
     */
    public function scopeFilterByRaceId(Builder $query, Int $raceId) : Builder
    {
        $query->where('race_id', $raceId);

        return $query;
    }

    /**
     * Scope to get runner races
     * @param Builder $query
     * @param Int $runnerId
     * @param tring $date
     * @return Builder $query
     */
    public function scopeGetRunnerRacesFilteringByDate(Builder $query, Int $runnerId, string $date) : Builder
    {
        $query->leftJoin('race', 'race.id', '=', 'race_runner.race_id')
              ->filterByRunnerId($runnerId)
              ->filterByRaceDate($date);

        return $query;
    }

    /**
     * Scope to filter by race date
     * @param Builder $query
     * @param String $date
     * @return Builder $query
     */
    public function scopeFilterByRaceDate(Builder $query, String $date) : Builder
    {
        $query->where('race.date', $date);

        return $query;
    }
}
