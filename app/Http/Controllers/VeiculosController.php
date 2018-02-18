<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veiculo;
use App\Http\Requests\VeiculoRequest;

class VeiculosController extends Controller
{
    private $veiculo;

    public function __construct(Veiculo $veiculo)
    {
        $this->veiculo = $veiculo;
    }

    public function index(Request $request)
    {
        $modelo = $marca = '';
        $column = 'veiculos.modelo';
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

        $veiculos = $this->veiculo->orderBy($column, $direction)
                         ->join('marcas', 'marcas.id', '=', 'veiculos.marca_id')
                         ->select('veiculos.id', 'veiculos.modelo', 'veiculos.placa', 'veiculos.ano', 'marcas.descricao AS marca');

        if($request->has('modelo')) {
            $veiculos = $veiculos->where('veiculos.modelo', 'LIKE', "%". $request->input('modelo') ."%");
            $modelo = $request->input('modelo');
        }

        if($request->has('marca')) {
            $veiculos = $veiculos->where('marcas.descricao', 'LIKE', "%". $request->input('marca') ."%");
            $marca = $request->input('marca');
        }

        $veiculos = $veiculos->paginate($per_page);

        $response = [
            'veiculos' => $veiculos,
            'params' => [
                'total' => $veiculos->total(),
                'per_page' => $veiculos->perPage(),
                'current_page' => $veiculos->currentPage(),
                'last_page' => $veiculos->lastPage(),
                'next_page_url' => $veiculos->nextPageUrl(),
                'prev_page_url' => $veiculos->previousPageUrl(),
                'direction' => $direction,
                'column' => $column
            ],
            'filters' => [
                'modelo' => $modelo,
                'marca' => $marca
            ]
        ];

        return response()->json($response);
    }

    public function store(VeiculoRequest $request)
    {
        $input = $request->all();
        $this->veiculo->create($input);
        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG001')
        ]);
    }

    public function show($id)
    {
        $veiculo = $this->veiculo->with('pais', 'proprietario', 'marca')->find($id);

        if(count($veiculo) > 0)
            return response()->json($veiculo);

        return response()->json(['error' => 'Resource not found!'], 404);
    }

    public function update(VeiculoRequest $request, $id)
    {
        $veiculo = $this->veiculo->find($id);
        $veiculo->update($request->all());
        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG002')
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->veiculo->destroy($id);

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
}
