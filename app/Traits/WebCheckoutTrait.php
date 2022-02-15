<?php

namespace App\Traits;

/**
 * mock para manejar los estados
 */
class States {
    const CREATED = 0;
    const APPROVED = 1;
    const REJECTED = 2;
    const PENDING = 3;
}

trait WebCheckoutTrait
{
    /**
     * @desc Retorna el id del estado
     * @author Juan Pablo Camargo Vanegas
     * @param string $state
     * @return mixed
     */
    public function getState(string $state){
        return constant("App\Traits\States::$state");
    }
}
