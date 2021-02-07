<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Services\RunnerService;

class RunnerServiceTest extends TestCase
{
    /*
    * Return runner
    */
    private function getRunner()
    {
        return [
            'name' => 'weqe',
            'cpf' => 11111111111,
            'birth_date' => '1989-12-10'
        ];
    }

   /*
    * Setup all needed services
    */
    private function setupServices()
    {
        $this->runnerService = $this->getMockBuilder('App\Services\RunnerService')
        ->setMethods(['validadeAge', 'save'])
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

        $runner = $this->getRunner();
        $saved = [
            'msg' => RunnerService::SAVED,
            'runner' => $runner
        ];

        $this->runnerService->method('save')->will($this->returnValue($saved));

        $this->runnerService->method('validadeAge')->will($this->returnValue(true));

        $result = $this->runnerService->create($runner);

        $this->assertEquals($result, $saved);
    }

    /**
     * @test
     * @group create
     */
    public function createInvalidAge()
    {
        $this->setupServices();

        $runner = $this->getRunner();
        $invalidAge = ['msg' => RunnerService::INVALID_AGE];

        $this->runnerService->method('validadeAge')->will($this->returnValue(false));

        $result = $this->runnerService->create($runner);

        $this->assertEquals($result, $invalidAge);
    }
}
