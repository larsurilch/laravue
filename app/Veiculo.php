<?php

namespace App;
use Carbon\Carbon;

class Veiculo extends BaseModel
{
    protected $table = 'veiculos';

    protected $fillable = ['modelo', 'proprietario_id', 'placa', 'ano', 'quilometragem', 'combustivel', 'marca_id',
        'data_cotacao', 'preco', 'pais_id', 'descricao'];

    public function getDataCotacaoAttribute($v)
    {
        return $v ? Carbon::parse($v)->format('d/m/Y') : null;
    }

    public function setDataCotacaoAttribute($v)
    {
        $this->attributes['data_cotacao'] = toSQL($v);
    }

    public function proprietario()
    {
        return $this->belongsTo('App\Proprietario');
    }

    public function marca()
    {
        return $this->belongsTo('App\Marca');
    }

    public function pais()
    {
        return $this->belongsTo('App\Pais');
    }
}
