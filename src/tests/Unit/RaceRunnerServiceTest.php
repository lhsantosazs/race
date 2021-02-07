<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Services\RaceRunnerService;
use App\Services\RaceService;
use App\Models\RaceRunner;

class RaceRunnerServiceTest extends TestCase
{

    /*
    * Return race
    */
    private function getRace()
    {
        return [
            0 => [
                'type' => '10',
                'date' => '2010-01-05'
            ]
        ];
    }

    /*
    * Return race runner
    */
    private function getRaceRunner()
    {
        return [
            'runner_id' => 1,
            'race_id' => 6
        ];
    }

    /*
    * Return runner
    */
    private function getRaceRunnerResults()
    {
        return [
            'runner_id' => 1,
            'race_id' => 6,
            'race_start' => '2010-01-05 22:22:22',
            'race_end' => '2010-01-05 22:44:11'
        ];
    }

    /*
    * Return race runner
    */
    private function papulateRaceRunner(array $raceRunnerResults) : RaceRunner
    {
        $raceRunnerResultsObj = new RaceRunner();
        $raceRunnerResultsObj->runner_id = $raceRunnerResults['runner_id'];
        $raceRunnerResultsObj->race_id = $raceRunnerResults['race_id'];
        $raceRunnerResultsObj->race_start = null;
        $raceRunnerResultsObj->race_end = null;

        return $raceRunnerResultsObj;
    }

    /*
    * Setup all needed services
    */
    private function setupServices()
    {
        $this->raceService = $this->getMockBuilder('App\Services\RaceService')
        ->setMethods(['filterByRaceId'])
        ->disableOriginalConstructor()
        ->getMock();

        $this->raceRunnerService = $this->getMockBuilder('App\Services\RaceRunnerService')
        ->setConstructorArgs([$this->raceService])
        ->setMethods(['validadeRunnerRacesGivenADate', 'getRaceRunner', 'save'])
        ->getMock();
    }

    /**
     * @test
     * @group create
     */
    public function createSuccess()
    {
        $this->setupServices();

        $race = $this->getRace();
        $raceRunner = $this->getRaceRunner();

        $saved = [
            'msg' => RaceRunnerService::SAVED,
            'raceRunner' => $raceRunner
        ];

        $this->raceService->method('filterByRaceId')->will($this->returnValue($race));
        $this->raceRunnerService->method('validadeRunnerRacesGivenADate')->will($this->returnValue(false));
        $this->raceRunnerService->method('save')->will($this->returnValue($saved));

        $result = $this->raceRunnerService->create($raceRunner);

        $this->assertEquals($result, $saved);
    }

    /**
     * @test
     * @group create
     */
    public function createInvalidRaceRunner()
    {
        $this->setupServices();

        $race = $this->getRace();
        $raceRunner = $this->getRaceRunner();

        $invalidRaceRunner = [
            'msg' => RaceRunnerService::INVALID_RACE_RUNNER
        ];

        $this->raceService->method('filterByRaceId')->will($this->returnValue($race));
        $this->raceRunnerService->method('validadeRunnerRacesGivenADate')->will($this->returnValue(true));

        $result = $this->raceRunnerService->create($raceRunner);

        $this->assertEquals($result, $invalidRaceRunner);
    }

    /**
     * @test
     * @group setResults
     */
    public function setResultsSuccess()
    {
        $this->setupServices();

        $raceRunnerResults = $this->getRaceRunnerResults();
        $raceRunnerResultsObj = $this->papulateRaceRunner($raceRunnerResults);

        $saved = [
            'msg' => RaceRunnerService::SAVED,
            'raceRunner' => $raceRunnerResults
        ];

        $this->raceRunnerService->method('getRaceRunner')->will($this->returnValue($raceRunnerResultsObj));
        $this->raceRunnerService->method('save')->will($this->returnValue($saved));

        $result = $this->raceRunnerService->setResults($raceRunnerResults);

        $this->assertEquals($result, $saved);
    }

     /**
     * @test
     * @group setResults
     */
    public function setResultsInvalidRacePeriod()
    {
        $this->setupServices();

        $raceRunnerResults = $this->getRaceRunnerResults();
        $raceRunnerResults['race_start'] = '2010-01-06 22:22:22';
        $invalidRacePeriod = [
            'msg' => RaceRunnerService::INVALID_RACE_PERIOD
        ];

        $result = $this->raceRunnerService->setResults($raceRunnerResults);

        $this->assertEquals($result, $invalidRacePeriod);
    }

     /**
     * @test
     * @group setResults
     */
    public function setResultsRaceResultsAlreadySaved()
    {
        $this->setupServices();

        $raceRunnerResults = $this->getRaceRunnerResults();
        $raceRunnerResultsObj = $this->papulateRaceRunner($raceRunnerResults);
        $raceRunnerResultsObj->race_start = $raceRunnerResults['race_start'];

        $raceResultsAlreadySaved = [
            'msg' => RaceRunnerService::RACE_RESULTS_ALREADY_SAVED
        ];

        $this->raceRunnerService->method('getRaceRunner')->will($this->returnValue($raceRunnerResultsObj));

        $result = $this->raceRunnerService->setResults($raceRunnerResults);

        $this->assertEquals($result, $raceResultsAlreadySaved);
    }
}
