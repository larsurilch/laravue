<?php

namespace App;

class Perfil extends BaseModel
{
    protected $table = 'perfis';

    protected $fillable = ['descricao'];

    protected $appends = ['acao_list'];

    public function acoes()
    {
        return $this->belongsToMany('App\Acao', 'acoes_perfis', 'perfil_id', 'acao_id')->withTimestamps();
    }

    public static function listPerfis()
    {
        return static::orderBy('descricao')->pluck('descricao', 'id');
    }

    public function getAcaoListAttribute()
    {
        return array_map('strval',$this->acoes->pluck('id')->toArray());
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($perfil) {
            $perfil->acoes()->detach();
        });
    }
}
