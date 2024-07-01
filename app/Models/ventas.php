<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventas extends Model
{
    use HasFactory;
    protected $table = 'ventas';

    protected $fillable = [
        'id_personal',
        'total'];
    public function user(){
        return $this->belongsTo(User::class, 'id_personal');
    }
    public function detalles(){
        return $this->hasMany(detallesVentas::class,'id_venta');
    }
            
     
        
    
}
