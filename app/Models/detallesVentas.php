<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detallesVentas extends Model
{
    use HasFactory;
    protected $table = 'detalleVentas';
    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad',
        'precio',
    ];
    public function venta(){
        return $this->belongsTo(ventas::class,'id_venta');
    }
    public function producto(){
        return $this->belongsTo(Product::class,'id_producto');
    }
}
