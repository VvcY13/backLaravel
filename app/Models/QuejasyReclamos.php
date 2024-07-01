<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuejasyReclamos extends Model
{
    use HasFactory;
    protected $table = 'quejasyreclamos';
    protected $fillable = ['id_personal', 'asunto', 'comentario'];
    public function user(){
        return $this->belongsTo(User::class,'id_personal');
    }
}
