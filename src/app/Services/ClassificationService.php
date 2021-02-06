<?php

namespace App\Services;

use App\Models\RaceRunner;
use App\Services\RaceRunnerService;
use Carbon\Carbon;

class ClassificationService
{
    /**
     * Constructor to instantiate Request
     * @param RaceRunnerService $raceRunnerService
     */
    public function __construct(RaceRunnerService $raceRunnerService)
    {
        $this->raceRunnerService = $raceRunnerService;
    }

    /**
     * Get classification by age
     * @return array
     */
    public function byAge() : array
    {
        $validResults = $this->raceRunnerService->getValidResults();
        $finalResults = [];

        foreach ($validResults as $result) {
            $result['raceTimeInSeconds'] = $this->calcRaceTime($result);
            $result['age'] = Carbon::createFromFormat("Y-m-d", $result['birth_date'])->age;
            
            $this->splitByAge($finalResults, $result);
        }

        foreach ($finalResults as $indexType => $type) {
            foreach ($type as $indexAge => $age) {
                $this->sortByRaceTime($finalResults[$indexType][$indexAge]);
            }
        }

        foreach ($finalResults as $indexType => $type) {
            foreach ($type as $indexAge => $age) {
                foreach ($age as $indexResult => $result) {
                    $finalResults[$indexType][$indexAge][$indexResult] = $this->format($result, $indexResult);
                }
            }
        }

        return $finalResults;
    }

    /**
     * Get overall classification
     * @return array
     */
    public function overall() : array
    {
        $validResults = $this->raceRunnerService->getValidResults();
        $finalResults = [];

        foreach ($validResults as $result) {
            $result['raceTimeInSeconds'] = $this->calcRaceTime($result);
            $result['age'] = Carbon::createFromFormat("Y-m-d", $result['birth_date'])->age;

            $finalResults[$result['type']][] = $result;
        }

        foreach ($finalResults as $indexType => $type) {
            $this->sortByRaceTime($finalResults[$indexType]);
        }

        foreach ($finalResults as $indexType => $type) {
            foreach ($type as $indexResult => $result) {
                $finalResults[$indexType][$indexResult] = $this->format($result, $indexResult);
            }
        }

        return $finalResults;
    }

    /**
     * Split by age
     * @param array &$finalResults
     * @param array $result
    */
    protected function splitByAge(array &$finalResults, array $result)
    {
        $age =  $result['age'];

        if ($age >= 18 && $age <= 25) {
            $finalResults[$result['type']]['18 - 25 anos'][] = $result;
        } else if ($age > 25 && $age <= 35) {
            $finalResults[$result['type']]['25 - 35 anos'][] = $result;
        } else if ($age > 35 && $age <= 45) {
            $finalResults[$result['type']]['35 - 45 anos'][] = $result;
        } else if ($age > 45 && $age <= 55) {
            $finalResults[$result['type']]['45 - 55 anos'][] = $result;
        } else {
            $finalResults[$result['type']]['Acima de 55 anos'][] = $result;
        }
    }

    /**
     * Sort by race time
     * @param array &$finalResults
    */
    protected function sortByRaceTime(array &$finalResults)
    {
        usort($finalResults, function ($a, $b) {
            if ($a['raceTimeInSeconds'] == $b['raceTimeInSeconds']) {
                return 0;
            }

            return ($a['raceTimeInSeconds'] < $b['raceTimeInSeconds']) ? -1 : 1;
        });
    }

    /**
     * Sort by race time
     * @param array $result
     * @return Int
    */
    protected function calcRaceTime(array $result) : Int
    {
        $start = Carbon::createFromFormat("Y-m-d H:i:s", $result['race_start']);
        $end = Carbon::createFromFormat("Y-m-d H:i:s", $result['race_end']);

        return  $end->diffInSeconds($start);
    }

    /**
     * Format classification
     * @param array $result
     * @param Int $position
     * @return array
    */
    protected function format(array $result, Int $position) : Array
    {
        return [
            'ID da prova' => $result['race_id'],
            'Tipo de prova' => $result['type'],
            'ID do corredor' => $result['runner_id'],
            'Idade' => $result['age'],
            'Nome do corredor' => $result['name'],
            'Posição' => $position + 1
        ];
    }
}
