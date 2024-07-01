<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carrito';
    protected $fillable = ['id_personal'];

    public function personal(){
        return $this->belongsTo(User::class);
    }
    public function detalles(){
        return $this->hasMany(DetalleCarrito::class, 'id_carrito','id');
    }
}
