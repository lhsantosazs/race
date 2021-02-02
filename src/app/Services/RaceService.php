<?php

namespace App\Services;

use App\Models\Race;
use Carbon\Carbon;

class RaceService
{
    const SAVED = 'Corrida salva com sucesso';
    const FAIL = 'Falha ao salvar corrida';

    /**
     * Create a race
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        $race = new Race();
    
        $race->type = $params['type'];
        $race->date = $params['date'];

        return $this->save($race);
    }

    /**
     * Save race data in database
     * @param Race $race
     * @return Array
    */
    protected function save(Race $race) : array
    {
        $saved = $race->save();

        return [
            'msg' => $saved ? self::SAVED : self::FAIL,
            'race' => $race
        ];
    }

    /**
     * Filter by race id
     * @param Int $race_id
     * @return Array
    */
    public function filterByRaceId(Int $race_id) : array
    {
        return Race::filterByRaceId($race_id)->get()->toArray();
    }
}
