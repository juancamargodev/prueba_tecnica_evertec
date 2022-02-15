<?php

namespace App\Repositories;

use App\Models\Orders;
use Laravel\Lumen\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdersRepository implements interfaces\IOrderRepository
{
    private $model;

    public function __construct(Orders $orders){
        $this->model = $orders;
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
        $data = $this->model->find($id);
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function orderByUserId(int $userId){
        return $this->model->where('user_id', $userId)->with('products')->orderBy('created_at', 'desc')->get();
    }

    /**
     * @inheritDoc
     */
    public function validateOrderAndUser(int $orderId, int $userId){
        return $this->model->where('id',$orderId)
                            ->where('user_id', $userId)
                            ->first();
    }

    /**
     * @inheritDoc
     */
    public function update(int $orderId, array $data)
    {
        return $this->model->where([
            'id' => $orderId,
            'user_id' => $data['user_id'],
        ])->update([
            'status' => $data['status']
        ]);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        $this->model->user_id = $data['user_id'];
        $this->model->save();
        if(isset($data['products'])){
            foreach ($data['products'] as $product){
                $this->model->products()->attach($product['id']);
            }
        }
        return $this->model->id;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

}
