<?php

namespace App;

class Proprietario extends BaseModel
{
    protected $table = 'proprietarios';

    protected $fillable = ['nome', 'tipo', 'documento', 'fone_principal', 'endereco', 'complemento', 'bairro', 'cep',
        'estado_id', 'cidade_id'];

    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    public function cidade()
    {
        return $this->belongsTo('App\Cidade');
    }

    public static function listProprietarios()
    {
        return static::orderBy('nome')->pluck('nome', 'id');
    }
}
