<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = ['email', 'senha', 'perfil_id', 'ativo'];

    protected $hidden = ['senha', 'remember_token'];

    public function perfil()
    {
        return $this->belongsTo('App\Perfil', 'perfil_id');
    }

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
