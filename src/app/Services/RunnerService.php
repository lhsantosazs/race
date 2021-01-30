<?php

namespace App\Services;

use App\Models\Runner;
use Carbon\Carbon;

class RunnerService
{
    const MIN_AGE = 18;
    const INVALID_AGE = 'Somente são permitidos corredores acima de 18 anos';
    const SAVED = 'Corredor salvo com sucesso';
    const FAIL = 'Falha ao salvar corredor';

    /**
     * Create a runner
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        $runner = new Runner();

        //Validade age
        if (!$this->validadeAge($params['birth_date'])) {
            return ['msg' => self::INVALID_AGE];
        }
    
        $runner->name = $params['name'];
        $runner->cpf = $params['cpf'];
        $runner->birth_date = $params['birth_date'];

        return $this->save($runner);
    }

    /**
     * Save runner data in database
     * @param Runner $runner
     * @return Array
    */
    protected function save(Runner $runner)
    {
        $saved = $runner->save();

        return [
            'msg' => $saved ? self::SAVED : self::FAIL,
            'runner' => $runner
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
