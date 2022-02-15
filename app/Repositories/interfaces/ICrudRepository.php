<?php

namespace App\Repositories\interfaces;

use Laravel\Lumen\Http\Request;

interface ICrudRepository
{
    /**
     * @desc regresa los datos del modelo
     * @author Juan Pablo Camargo Vanegas
     * @return mixed
     */
    public function all();

    /**
     * @desc crea los datos del modelo
     * @author Juan Pablo Camargo Vanegas
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @desc actualiza los datos del modelo
     * @author Juan Pablo Camargo Vanegas
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @desc elimina los datos del modelo
     * @author Juan Pablo Camargo Vanegas
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * @desc busca los datos del modelo según su id
     * @author Juan Pablo Camargo Vanegas
     * @param int $id
     * @return mixed
     */
    public function find(int $id);
}
