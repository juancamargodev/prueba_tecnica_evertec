<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const http\Client\Curl\PROXY_HTTP;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = ['status','data'];

    /**
     * @desc Establece la relación con los usuarios
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * @desc Establece la relación con los productos
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(){
        return $this->belongsToMany(
            Products::class,
            'orders_products',
            'order_id',
            'product_id');
    }
}
