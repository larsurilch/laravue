<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proprietario;
use App\Http\Requests\ProprietarioRequest;

class ProprietariosController extends Controller
{
    private $proprietario;

    public function __construct(Proprietario $proprietario)
    {
        $this->proprietario = $proprietario;
    }

    public function index(Request $request)
    {
        $nome = '';
        $column = 'nome';
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

        $proprietarios = $this->proprietario->orderBy($column, $direction);

        if($request->has('nome')) {
            $proprietarios = $proprietarios->where('nome', 'LIKE', "%". $request->input('nome') ."%");
            $nome = $request->input('nome');
        }

        $proprietarios = $proprietarios->paginate($per_page);

        $response = [
            'proprietarios' => $proprietarios,
            'params' => [
                'total' => $proprietarios->total(),
                'per_page' => $proprietarios->perPage(),
                'current_page' => $proprietarios->currentPage(),
                'last_page' => $proprietarios->lastPage(),
                'next_page_url' => $proprietarios->nextPageUrl(),
                'prev_page_url' => $proprietarios->previousPageUrl(),
                'direction' => $direction,
                'column' => $column
            ],
            'filters' => [
                'nome' => $nome
            ]
        ];

        return response()->json($response);
    }

    public function store(ProprietarioRequest $request)
    {
        $input = $request->all();
        $this->proprietario->create($input);
        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG001')
        ]);
    }

    public function show($id)
    {
        $proprietario = $this->proprietario->find($id);

        if(count($proprietario) > 0)
            return response()->json($proprietario);

        return response()->json(['error' => 'Resource not found!'], 404);
    }

    public function update(ProprietarioRequest $request, $id)
    {
        $proprietario = $this->proprietario->find($id);
        $proprietario->update($request->all());
        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG002')
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->proprietario->destroy($id);

            return response()->json([
                'success' => true,
                'status' => 'positive',
                'message' => message('MSG003')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'negative',
                'message' => message('MSG005 ')
            ]);
        }
    }

    public function listing()
    {
        return response()->json([
            'list' => $this->proprietario->listProprietarios()
        ]);
    }
}
