<?php

namespace App\Http\Controllers;
use App\Http\Requests\PerfilRequest;
use App\Perfil;

use Illuminate\Http\Request;

class PerfisController extends Controller
{
    private $perfil;

    public function __construct(Perfil $perfil)
    {
        $this->perfil = $perfil;
    }

    public function index(Request $request)
    {
        $descricao = '';
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

        $perfis = $this->perfil->orderBy($column, $direction);

        if($request->has('descricao')) {
            $perfis = $perfis->where('descricao', 'LIKE', "%". $request->input('descricao') ."%");
            $descricao = $request->input('descricao');
        }

        $perfis = $perfis->paginate($per_page);

        $response = [
            'perfis' => $perfis,
            'params' => [
                'total' => $perfis->total(),
                'per_page' => $perfis->perPage(),
                'current_page' => $perfis->currentPage(),
                'last_page' => $perfis->lastPage(),
                'next_page_url' => $perfis->nextPageUrl(),
                'prev_page_url' => $perfis->previousPageUrl(),
                'direction' => $direction,
                'column' => $column
            ],
            'filters' => [
                'descricao' => $descricao
            ]
        ];

        return response()->json($response);
    }

    public function store(PerfilRequest $request)
    {
        $input = $request->all();
        $perfil = $this->perfil->create($input);
        $this->syncAcoes($perfil, $request->input('acao_list'));
        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG001')
        ]);
    }

    public function show($id)
    {
        $perfil = $this->perfil->with('acoes')->find($id);

        if(count($perfil) > 0)
            return response()->json($perfil);

        return response()->json(['error' => 'Resource not found!'], 404);
    }

    public function update(PerfilRequest $request, $id)
    {
        $perfil = $this->perfil->find($id);
        $perfil->update($request->all());
        $this->syncAcoes($perfil, $request->input('acao_list'));
        return response()->json([
            'success' => true,
            'status' => 'positive',
            'message' => message('MSG002')
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->perfil->destroy($id);

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

    public  function listing()
    {
        return response()->json([
            'list' => $this->perfil->listPerfis()
        ]);
    }

    private function syncAcoes(Perfil $perfil, array $acoes) {
        $perfil->acoes()->sync($acoes);
    }
}
