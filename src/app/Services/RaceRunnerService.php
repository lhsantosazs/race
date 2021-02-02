<?php

namespace App\Services;

use App\Models\RaceRunner;
use App\Models\Race;
use Carbon\Carbon;

class RaceRunnerService
{
    const INVALID_RACE_RUNNER = 'Erro ao cadastrar o mesmo corredor em duas provas diferentes na mesma data';
    const SAVED = 'Corredor salvo na corrida com sucesso';
    const FAIL = 'Falha ao salvar corredor na corrida';

    /**
     * Create a raceRunner
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        $runner_id = $params['runner_id'];
        $race_id = $params['race_id'];

        $race = Race::filterByRaceId($race_id)->get()->toArray();

        $newRaceDate = $race[0]['date'];
        /*\DB::enableQueryLog();*/
        $raceRunnerFound = RaceRunner::getRunnerRacesFilteringByDate($runner_id, $newRaceDate)->get()->toArray();
        /*dd(\DB::getQueryLog());*/

        //Validade existing race in the same date
        if (!empty($raceRunnerFound)) {
            return ['msg' => self::INVALID_RACE_RUNNER];
        }

        $raceRunner = new RaceRunner();
        $raceRunner->runner_id = $runner_id;
        $raceRunner->race_id = $race_id;

        return $this->save($raceRunner);
    }

    /**
     * Save raceRunner data in database
     * @param RaceRunner $raceRunner
     * @return Array
    */
    protected function save(RaceRunner $raceRunner)
    {
        $saved = $raceRunner->save();

        return [
            'msg' => $saved ? self::SAVED : self::FAIL,
            'raceRunner' => $raceRunner
        ];
    }
    
    /**
     * Validade age greater than MIN
     * @param string $age
     * @return bool
    */
    protected function validadeAge(string $age) : bool
    {
        $age = Carbon::createFromFormat("Y-m-d", $age)->age;

        return $age >= self::MIN_AGE;
    }
}
