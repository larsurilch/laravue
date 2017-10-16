<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cidade;

class CidadesController extends Controller
{
    private $cidade;

    public function __construct(Cidade $cidade)
    {
        $this->cidade = $cidade;
    }

    public function index(Request $request)
    {
        $nome = $uf = '';
        $column = 'nome';
        $direction = 'asc';
        $per_page = 30;

        if($request->has('per_page')) {
            $per_page = $request->input('per_page');
        }

        if($request->has('direction')) {
            $direction = $request->input('direction');
        }

        if($request->has('column')) {
            $column = $request->input('column');
        }

        $cidades = $this->cidade->orderBy($column, $direction);

        if($request->has('nome')) {
            $cidades = $cidades->where('nome', 'LIKE', "%". $request->input('nome') ."%");
            $nome = $request->input('nome');
        }

        if($request->has('uf')) {
            $cidades = $cidades->where('uf', 'LIKE', "%". $request->input('uf') ."%");
            $uf = $request->input('uf');
        }

        $cidades = $cidades->paginate($per_page);

        $response = [
            'cidades' => $cidades,
            'params' => [
                'total' => $cidades->total(),
                'per_page' => $cidades->perPage(),
                'current_page' => $cidades->currentPage(),
                'last_page' => $cidades->lastPage(),
                'next_page_url' => $cidades->nextPageUrl(),
                'prev_page_url' => $cidades->previousPageUrl(),
                'direction' => $direction,
                'column' => $column
            ],
            'filters' => [
                'nome' => $nome,
                'uf' => $uf
            ]
        ];

        return response()->json($response);
    }

    public function listing($estado_id)
    {
        return response()->json([
            'list' => $this->cidade->listCidades($estado_id)
        ]);
    }
}
