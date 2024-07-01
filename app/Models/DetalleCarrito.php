<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCarrito extends Model
{
    protected $table = 'detallecarrito';
    use HasFactory;
    protected $fillable = ['id_carrito', 'id_producto', 'cantidad', 'precio'];

    public function carrito(){
        return $this->belongsTo(Carrito::class,'id_carrito','id');

    }
    public function producto(){
        return $this->belongsTo(Product::class,'id_producto','id');
    }
}
