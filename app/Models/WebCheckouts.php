<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebCheckouts extends Model
{
    protected $fillable = ['order_id', 'payment_request', 'payment_response', 'payment_url'];
}
