<?php

namespace App;

class Cidade extends BaseModel
{
    protected $table = 'cidades';

    protected $fillable = ['nome', 'uf', 'estado_id'];

    public static function listCidades($estado_id)
    {
        return static::orderBy('nome')->where('estado_id', '=', $estado_id)->pluck('nome', 'id');
    }

    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }
}
