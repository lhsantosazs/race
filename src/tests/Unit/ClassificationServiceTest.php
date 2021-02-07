<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\RaceRunnerService;
use App\Services\ClassificationService;

class ClassificationServiceTest extends TestCase
{
    /*
    * Return valid results
    */
    private function getValidResults()
    {
        return [
            0 => [
                'race_id' => 1,
                'type' => '5 Km',
                'date' => '2010-02-01',
                'runner_id' => 1,
                'name' => 'um',
                'birth_date' => '1989-12-10',
                'race_start' => '2010-01-05 22:22:22',
                'race_end' => '2010-01-05 22:44:11',
            ],
            1 => [
                'race_id' => 1,
                'type' => '5 Km',
                'date' => '2010-02-01',
                'runner_id' => 3,
                'name' => 'três',
                'birth_date' => '1999-12-10',
                'race_start' => '2010-01-05 22:22:22',
                'race_end' => '2010-01-05 22:30:22',
            ],
            2 => [
                'race_id' => 1,
                'type' => '5 Km',
                'date' => '2010-02-01',
                'runner_id' => 4,
                'name' => 'quarto',
                'birth_date' => '1989-12-10',
                'race_start' => '2010-01-05 22:22:22',
                'race_end' => '2010-01-05 22:46:11',
            ],
            3 => [
                'race_id' => 1,
                'type' => '5 Km',
                'date' => '2010-02-01',
                'runner_id' => 6,
                'name' => 'seis',
                'birth_date' => '1999-12-10',
                'race_start' => '2010-01-05 22:22:22',
                'race_end' => '2010-01-05 22:34:22',
            ],
            4 => [
                'race_id' => 2,
                'type' => '10 Km',
                'date' => '2010-02-01',
                'runner_id' => 1,
                'name' => 'um',
                'birth_date' => '1989-12-10',
                'race_start' => '2010-01-06 22:22:22',
                'race_end' => '2010-01-06 22:27:22',
            ],
            5 => [
                'race_id' => 2,
                'type' => '10 Km',
                'date' => '2010-02-01',
                'runner_id' => 2,
                'name' => 'dois',
                'birth_date' => '1979-12-10',
                'race_start' => '2010-01-06 22:22:22',
                'race_end' => '2010-01-06 22:32:22',
            ]
        ];
    }

    /*
    * Return ByAge Expected
    */
    private function getByAgeExpected()
    {
        return [
            '5 Km' => [
                '25 - 35 anos' => [
                    0 => [
                        'ID da prova' => 1,
                        'Tipo de prova' => '5 Km',
                        'ID do corredor' => 1,
                        'Idade' => 31,
                        'Nome do corredor' => 'um',
                        'Posição' => 1,
                    ],
                    1 => [
                        'ID da prova' => 1,
                        'Tipo de prova' => '5 Km',
                        'ID do corredor' => 4,
                        'Idade' => 31,
                        'Nome do corredor' => 'quarto',
                        'Posição' => 2,
                    ],
                ],
                '18 - 25 anos' => [
                    0 => [
                        'ID da prova' => 1,
                        'Tipo de prova' => '5 Km',
                        'ID do corredor' => 3,
                        'Idade' => 21,
                        'Nome do corredor' => 'três',
                        'Posição' => 1,
                    ],
                    1 => [
                        'ID da prova' => 1,
                        'Tipo de prova' => '5 Km',
                        'ID do corredor' => 6,
                        'Idade' => 21,
                        'Nome do corredor' => 'seis',
                        'Posição' => 2,
                    ],
                ],
            ],
            '10 Km' => [
                '25 - 35 anos' => [
                    0 => [
                        'ID da prova' => 2,
                        'Tipo de prova' => '10 Km',
                        'ID do corredor' => 1,
                        'Idade' => 31,
                        'Nome do corredor' => 'um',
                        'Posição' => 1,
                    ],
                ],
                '35 - 45 anos' => [
                    0 => [
                        'ID da prova' => 2,
                        'Tipo de prova' => '10 Km',
                        'ID do corredor' => 2,
                        'Idade' => 41,
                        'Nome do corredor' => 'dois',
                        'Posição' => 1,
                    ],
                ],
            ],
        ];
    }

    /*
    * Return Overall Expected
    */
    private function getOverallExpected()
    {
        return [
            '5 Km' => [
                0 => [
                    'ID da prova' => 1,
                    'Tipo de prova' => '5 Km',
                    'ID do corredor' => 3,
                    'Idade' => 21,
                    'Nome do corredor' => 'três',
                    'Posição' => 1,
                ],
                1 => [
                    'ID da prova' => 1,
                    'Tipo de prova' => '5 Km',
                    'ID do corredor' => 6,
                    'Idade' => 21,
                    'Nome do corredor' => 'seis',
                    'Posição' => 2,
                ],
                2 => [
                    'ID da prova' => 1,
                    'Tipo de prova' => '5 Km',
                    'ID do corredor' => 1,
                    'Idade' => 31,
                    'Nome do corredor' => 'um',
                    'Posição' => 3,
                ],
                3 => [
                    'ID da prova' => 1,
                    'Tipo de prova' => '5 Km',
                    'ID do corredor' => 4,
                    'Idade' => 31,
                    'Nome do corredor' => 'quarto',
                    'Posição' => 4,
                ],
            ],
            '10 Km' => [
                0 => [
                    'ID da prova' => 2,
                    'Tipo de prova' => '10 Km',
                    'ID do corredor' => 1,
                    'Idade' => 31,
                    'Nome do corredor' => 'um',
                    'Posição' => 1,
                ],
                1 => [
                    'ID da prova' => 2,
                    'Tipo de prova' => '10 Km',
                    'ID do corredor' => 2,
                    'Idade' => 41,
                    'Nome do corredor' => 'dois',
                    'Posição' => 2,
                ],
            ],
        ];
    }

    /*
    * Setup all needed services
    */
    private function setupServices()
    {
        $this->raceRunnerService = $this->getMockBuilder('App\Services\RaceRunnerService')
        ->setMethods(['getValidResults'])
        ->disableOriginalConstructor()
        ->getMock();

        $this->classificationService = new ClassificationService($this->raceRunnerService);
    }

    /**
     * @test
     * @group byAge
     */
    public function byAge()
    {
        $this->setupServices();

        $validResults = $this->getValidResults();
        $byAgeExpected = $this->getByAgeExpected();

        $this->raceRunnerService->method('getValidResults')->will($this->returnValue($validResults));

        $result = $this->classificationService->byAge();

        $this->assertEquals($result, $byAgeExpected);
    }

     /**
     * @test
     * @group overall
     */
    public function overall()
    {
        $this->setupServices();

        $validResults = $this->getValidResults();
        $overallExpected = $this->getOverallExpected();

        $this->raceRunnerService->method('getValidResults')->will($this->returnValue($validResults));

        $result = $this->classificationService->overall();

        $this->assertEquals($result, $overallExpected);
    }
}
