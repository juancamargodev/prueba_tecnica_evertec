<?php

namespace App\Repositories\interfaces;

interface IOrderRepository extends ICrudRepository
{
    /**
     * @desc Obtiene las ordenes según el userId
     * @author Juan Pablo Camargo Vanegas
     * @param int $userId
     * @return mixed
     */
    public function orderByUserId(int $userId);

    /**
     * @desc Valida la relación entre la orden y el usuario
     * @author Juan Pablo Camargo Vanegas
     * @param int $userId
     * @return mixed
     */
    public function validateOrderAndUser(int $orderId, int $userId);
}
