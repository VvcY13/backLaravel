<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'nombreProd',
        'marcaProd',
        'presentacionProd',
        'precioCompraProd',
        'precioVentaProd',
        'stockProd',
        'imagenProd',
    ];
    public function detallesCarrito(){
        return $this->hasMany(DetalleCarrito::class,'id_producto');
    }
}
