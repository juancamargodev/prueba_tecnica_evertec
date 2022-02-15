<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name','price'];

    /**
     * @desc Establece la relación con las ordenes
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function order(){
        return $this->belongsToMany(Orders::class);
    }
}
