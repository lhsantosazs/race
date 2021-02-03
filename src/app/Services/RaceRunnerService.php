<?php

namespace App\Services;

use App\Models\RaceRunner;
use App\Models\Race;
use App\Services\RaceService;
use Carbon\Carbon;

class RaceRunnerService
{
    const INVALID_RACE_RUNNER = 'Erro ao cadastrar o mesmo corredor em duas provas diferentes na mesma data';
    const INVALID_RACE_PERIOD = 'O fim da prova deve ser posterior ao início da mesma';
    const RACE_RESULTS_ALREADY_SAVED = 'Resultado de corrida ja cadastrado';
    const SAVED = 'Corredor salvo na corrida com sucesso';
    const FAIL = 'Falha ao salvar corredor na corrida';

    /**
     * Constructor to instantiate Request
     * @param RaceService $raceService
     */
    public function __construct(RaceService $raceService)
    {
        $this->raceService = $raceService;
    }

    /**
     * Create a raceRunner
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        $runner_id = $params['runner_id'];
        $race_id = $params['race_id'];

        $race = $this->raceService->filterByRaceId($race_id);
        $newRaceDate = $race[0]['date'];

        $runnerRaces = $this->validadeRunnerRacesGivenADate($runner_id, $newRaceDate);

        //Validade existing race in the same date
        if ($runnerRaces) {
            return ['msg' => self::INVALID_RACE_RUNNER];
        }

        $raceRunner = new RaceRunner();
        $raceRunner->runner_id = $runner_id;
        $raceRunner->race_id = $race_id;

        return $this->save($raceRunner);
    }

    /**
     * Set runner results
     * @param array $params
     * @return array
     */
    public function setResults(array $params) : array
    {
        $runner_id = $params['runner_id'];
        $race_id = $params['race_id'];
        $race_start = $params['race_start'];
        $race_end = $params['race_end'];

        if ($race_start > $race_end) {
            return ['msg' => self::INVALID_RACE_PERIOD];
        }

        $raceRunner = RaceRunner::filterByRaceId($race_id)->filterByRunnerId($runner_id)->first();

        if (!empty($raceRunner->race_start)) {
            return ['msg' => self::RACE_RESULTS_ALREADY_SAVED];
        }

        $raceRunner->race_start = $race_start;
        $raceRunner->race_end = $race_end;

        return $this->save($raceRunner);
    }

    /**
     * Save raceRunner data in database
     * @param RaceRunner $raceRunner
     * @return Array
    */
    protected function save(RaceRunner $raceRunner) : array
    {
        $saved = $raceRunner->save();

        return [
            'msg' => $saved ? self::SAVED : self::FAIL,
            'raceRunner' => $raceRunner
        ];
    }
    
    /**
     * Validade runner races with same data
     * @param Int $runner_id
     * @param String $newRaceDate
     * @return bool
    */
    protected function validadeRunnerRacesGivenADate(Int $runner_id, string $newRaceDate) : bool
    {
        /*\DB::enableQueryLog();*/
        return (!empty(RaceRunner::getRunnerRacesFilteringByDate($runner_id, $newRaceDate)->get()->toArray()));
        /*dd(\DB::getQueryLog());*/
    }
}
