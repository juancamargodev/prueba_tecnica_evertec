<?php

namespace App\Repositories;

use App\Models\WebCheckouts;
use App\Repositories\interfaces\IWebCheckoutRepository;
use App\Traits\WebCheckoutTrait;
use http\Env\Request;

class WebCheckoutRepository implements IWebCheckoutRepository
{

    private $model;

    public function __construct(WebCheckouts $webCheckouts){
        $this->model = $webCheckouts;
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        $this->model->order_id = $data['order_id'];
        $this->model->payment_request = $data['payment_request'];
        $this->model->payment_response = $data['payment_response'];
        if(isset($data['payment_url'])){
            $this->model->payment_url = $data['payment_url'];
        }
        $this->model->save();
        return $this->model->id;
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function updateOrCreate(array $data){
        return $this->model->updateOrCreate([
            'order_id' => $data['order_id'],
            'payment_response' => $data['payment_response'],
        ],[
            'payment_request' => $data['payment_request'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findByOrder(int $orderId){
        return $this->model->where('order_id', $orderId)->get()->last();
    }

    /**
     * @inheritDoc
     */
    public function getrequestUrl(int $orderId){
        return $this->model->where('order_id', $orderId)->whereNotNull('payment_url')->get()->first();
    }
}
