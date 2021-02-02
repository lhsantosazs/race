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
    protected function save(Race $race)
    {
        $saved = $race->save();

        return [
            'msg' => $saved ? self::SAVED : self::FAIL,
            'race' => $race
        ];
    }
}
