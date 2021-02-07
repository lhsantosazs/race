<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Services\RaceService;

class RaceServiceTest extends TestCase
{
    /*
    * Return race
    */
    private function getRace()
    {
        return [
            'type' => '10',
            'date' => '2010-01-05'
        ];
    }

   /*
    * Setup all needed services
    */
    private function setupServices()
    {
        $this->raceService = $this->getMockBuilder('App\Services\RaceService')
        ->setMethods(['save'])
        ->disableOriginalConstructor()
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
        $saved = [
            'msg' => RaceService::SAVED,
            'race' => $race
        ];

        $this->raceService->method('save')->will($this->returnValue($saved));

        $result = $this->raceService->create($race);

        $this->assertEquals($result, $saved);
    }
}
