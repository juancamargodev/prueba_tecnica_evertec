<?php

namespace App\Repositories\interfaces;

interface IWebCheckoutRepository extends ICrudRepository
{
    /**
     * @desc Retorna el ultimo dato del web checkout según el orderId
     * @author Juan Pablo Camargo Vanegas
     * @param int $orderId
     * @return mixed
     */
    public function findByOrder(int $orderId);

    /**
     * @desc Actualiza o cre un registro en la tabla
     * @author Juan Pablo Camargo Vanegas
     * @param array $data
     * @return mixed
     */
    public function updateOrCreate(array $data);

    /**
     * @desc Obtiene la url del web checkout
     * @author Juan Pablo Camargo Vanegas
     * @param int $orderId
     * @return mixed
     */
    public function getrequestUrl(int $orderId);
}
