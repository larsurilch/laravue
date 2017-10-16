<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;

class EstadosController extends Controller
{
    private $estado;

    public function __construct(Estado $estado)
    {
        $this->estado = $estado;
    }

    public function index(Request $request)
    {
        $descricao = $sigla = '';
        $column = 'descricao';
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

        $estados = $this->estado->orderBy($column, $direction);

        if($request->has('descricao')) {
            $estados = $estados->where('descricao', 'LIKE', "%". $request->input('descricao') ."%");
            $descricao = $request->input('descricao');
        }

        if($request->has('sigla')) {
            $estados = $estados->where('sigla', 'LIKE', "%". $request->input('sigla') ."%");
            $sigla = $request->input('sigla');
        }

        $estados = $estados->paginate($per_page);

        $response = [
            'estados' => $estados,
            'params' => [
                'total' => $estados->total(),
                'per_page' => $estados->perPage(),
                'current_page' => $estados->currentPage(),
                'last_page' => $estados->lastPage(),
                'next_page_url' => $estados->nextPageUrl(),
                'prev_page_url' => $estados->previousPageUrl(),
                'direction' => $direction,
                'column' => $column
            ],
            'filters' => [
                'descricao' => $descricao,
                'sigla' => $sigla
            ]
        ];

        return response()->json($response);
    }

    public function listing()
    {
        return response()->json([
            'list' => $this->estado->listEstados()
        ]);
    }
}
