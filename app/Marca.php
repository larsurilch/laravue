<?php

namespace App;

class Marca extends BaseModel
{
    protected $table = 'marcas';

    protected $fillable = ['descricao'];

    public static function listMarcas()
    {
        return static::orderBy('descricao')->pluck('descricao', 'id');
    }
}
