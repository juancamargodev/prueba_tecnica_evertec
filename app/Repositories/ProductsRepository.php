<?php

namespace App\Repositories;

use App\Models\Products;

class ProductsRepository implements interfaces\IProductRepository
{
    private $model;

    public function __construct(Products $products){
        $this->model = $products;
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->model->all();
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
    public function create(array $data)
    {
        $this->model->name = $data['name'];
        $this->model->price = $data['price'];
        $this->model->save();
        return $this->model->id;
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data)
    {
        return $this->model->where([
            'id' => $id
        ])->update([
            'name' => $data['name'],
            'price' => $data['price']
        ]);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {

    }

}
