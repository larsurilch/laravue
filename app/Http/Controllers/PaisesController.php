<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pais;

class PaisesController extends Controller
{
    private $pais;

    public function __construct(Pais $pais)
    {
        $this->pais = $pais;
    }

    public function index(Request $request)
    {
        $descricao = '';
        $column = 'descricao';
        $direction = 'asc';
        $per_page = 30;

        if($request->has('per_page')){
            $per_page = $request->input('per_page');
        }

        if($request->has('direction')){
            $direction = $request->input('direction');
        }

        if($request->has('column')){
            $column = $request->input('column');
        }

        $paises = $this->pais->orderBy($column, $direction);

        if($request->has('descricao')) {
            $paises = $paises->where('descricao', 'LIKE', "%". $request->input('descricao') ."%");
            $descricao = $request->input('descricao');
        }

        $paises = $paises->paginate($per_page);

        $response = [
            'paises' => $paises,
            'params' => [
                'total' => $paises->total(),
                'per_page' => $paises->perPage(),
                'current_page' => $paises->currentPage(),
                'last_page' => $paises->lastPage(),
                'next_page_url' => $paises->nextPageUrl(),
                'prev_page_url' => $paises->previousPageUrl(),
                'direction' => $direction,
                'column' => $column
            ],
            'filters' => [
                $descricao => 'descricao'
            ]
        ];

        return response()->json($response);
    }

    public function listing()
    {
        return response()->json([
            'list' => $this->pais->listPaises()
        ]);
    }
}
