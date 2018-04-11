<?php

namespace App\Http\Controllers;
use App\Acao;

use Illuminate\Http\Request;

class AcoesController extends Controller
{
    private $acao;

    public function __construct(Acao $acao)
    {
        $this->acao = $acao;
    }

    public  function listing()
    {
        return response()->json([
            'list' => $this->acao->listAcoes()
        ]);
    }
}
