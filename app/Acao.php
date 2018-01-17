<?php

namespace App;

class Acao extends BaseModel
{
    protected $table = 'acoes';

    protected $fillable = ['nome', 'metodo', 'ordem'];

    public function perfis()
    {
        return $this->belongsToMany('App\Perfil', 'acoes_perfis', 'acao_id', 'perfil_id')->withTimestamps();
    }

    public static function listAcoes()
    {
        return static::orderBy('ordem')->pluck('nome', 'id');
    }
}
