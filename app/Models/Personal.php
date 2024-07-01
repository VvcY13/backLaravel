<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Personal extends Model implements JWTSubject
{
    use HasFactory;
    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'contraseña',
        'direccion',
        'provincia',
        'distrito',
        'tipo_documento',
        'numero_documento',
        'rol',
        'estado'
    ];
    protected $hidden = [
        'contraseña'
        
    ];
    protected function casts(): array
    {
        return [
            
            'contraseña' => 'hashed'
        ];
    }
     /**
     * Get the identifier that will be stored in the JWT subject claim.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
