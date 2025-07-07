<?php
namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Foto;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Veiculo::latest()->get();

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtns = '
                        <a href="' . route("veiculo.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        <form action="' . route("veiculo.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('veiculos.index');
    }

    public function create()
    {
        return view('veiculos.crud');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $modelo = $request->post('modelo');
        $marca = $request->post('marca');
        $origem = $request->post('origem');
        $placa = $request->post('placa');
        $renavam = $request->post('renavam');
        $chassi = $request->post('chassi');
        $ano_fabricacao = $request->post('ano_fabricacao');
        $cor = $request->post('cor');
        $tipo_combustivel = $request->post('tipo_combustivel');
        $observacoes = $request->post('observacoes');

        $veiculo = new Veiculo();

        $veiculo->modelo = $modelo;
        $veiculo->marca = $marca;
        $veiculo->origem = $origem;
        $veiculo->placa = $placa;
        $veiculo->renavam = $renavam;
        $veiculo->chassi = $chassi;
        $veiculo->ano_fabricacao = $ano_fabricacao;
        $veiculo->cor = $cor;
        $veiculo->tipo_combustivel = $tipo_combustivel;
        $veiculo->observacoes = $observacoes;
        $veiculo->origin_user = $user->name;
        $veiculo->last_user = $user->name;
        $veiculo->save();

        // Salvar as fotos
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('fotos', 'public');
                $novaFoto = new Foto();
                $novaFoto->veiculo_id = $veiculo->id;
                $novaFoto->caminho = $path;
                $novaFoto->save();
            }
        }

        return view('veiculos.index');
    }

    public function edit(string $id)
    {
        $edit = Veiculo::find($id);

        $output = array(
            'edit' => $edit,
        );
        return view('veiculos.crud', $output);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $modelo = $request->post('modelo');
        $marca = $request->post('marca');
        $origem = $request->post('origem');
        $placa = $request->post('placa');
        $renavam = $request->post('renavam');
        $chassi = $request->post('chassi');
        $ano_fabricacao = $request->post('ano_fabricacao');
        $cor = $request->post('cor');
        $tipo_combustivel = $request->post('tipo_combustivel');
        $observacoes = $request->post('observacoes');
    

        $veiculo = Veiculo::find($id);

        $veiculo->modelo = $modelo;
        $veiculo->marca = $marca;
        $veiculo->origem = $origem;
        $veiculo->placa = $placa;
        $veiculo->renavam = $renavam;
        $veiculo->chassi = $chassi;
        $veiculo->ano_fabricacao = $ano_fabricacao;
        $veiculo->cor = $cor;
        $veiculo->tipo_combustivel = $tipo_combustivel;
        $veiculo->observacoes = $observacoes;
        $veiculo->origin_user = $user->name;
        $veiculo->last_user = $user->name;
        $veiculo->save();

        // Salvar novas fotos (adiciona sem apagar as antigas)
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('fotos', 'public');
                $novaFoto = new Foto();
                $novaFoto->veiculo_id = $veiculo->id;
                $novaFoto->caminho = $path;
                $novaFoto->save();
            }
        }

        return view('veiculos.index');
    }

    public function destroy(string $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        $veiculo->delete();

        return view('veiculos.index');
    }

    public function show($id)
    {
        $veiculo = Veiculo::with('fotos')->findOrFail($id);
        return view('veiculos.show', compact('veiculo'));
    }
}
