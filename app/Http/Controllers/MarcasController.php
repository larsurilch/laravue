<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;
use App\Http\Requests\MarcaRequest;

class MarcasController extends Controller
{
    private $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
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

        $marcas = $this->marca->orderBy($column, $direction);

        if($request->has('descricao')) {
            $marcas = $marcas->where('descricao', 'LIKE', "%". $request->input('descricao') ."%");
            $descricao = $request->input('descricao');
        }

        $marcas = $marcas->paginate($per_page);

        $response = [
            'marcas' => $marcas,
            'params' => [
                'total' => $marcas->total(),
                'per_page' => $marcas->perPage(),
                'current_page' => $marcas->currentPage(),
                'last_page' => $marcas->lastPage(),
                'next_page_url' => $marcas->nextPageUrl(),
                'prev_page_url' => $marcas->previousPageUrl(),
                'direction' => $direction,
                'column' => $column
            ],
            'filters' => [
                'descricao' => $descricao
            ]
        ];

        return response()->json($response);
    }

    public function store(MarcaRequest $request)
    {
        $input = $request->all();
        $this->marca->create($input);
        return response()->json([
           'success' => true,
           'status' => 'positive',
            'message' => message('MSG001')
        ]);
    }

    public function show($id)
    {
        $marca = $this->marca->find($id);

        if(count($marca) > 0)
            return response()->json($marca);

        return response()->json(['error' => 'Resource not found!'], 404);
    }

    public function update(MarcaRequest $request, $id)
    {
        $marca = $this->marca->find($id);
        $marca->update($request->all());
        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG002')
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->marca->destroy($id);

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
            'list' => $this->marca->listMarcas()
        ]);
    }
}
