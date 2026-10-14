<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanceira;
use Carbon\Carbon;
use App\Models\Veiculo;
use App\Models\Cliente;
use App\Models\Locacao;
use App\Models\FluxoCaixa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LocacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {

            $data = Locacao::with(['veiculo', 'cliente'])
                ->where('data_devolucao', '=', null)
                ->where('deletado', '=', 0)
                ->get(); // Certifique-se de carregar as relações

            return DataTables::of($data)

                ->addColumn('data_locacao', function ($row) {
                 return \Carbon\Carbon::parse($row->data_locacao)->format('d/m/Y'); // Ajusta o campo no formato D/M/Y
                    })
                ->addColumn('data_prevista_devolucao', function ($row) {
                 return \Carbon\Carbon::parse($row->data_prevista_devolucao)->format('d/m/Y'); // Ajusta o campo no formato D/M/Y
                })
                ->addColumn('modelo', function ($row) {
                    return $row->veiculo->modelo ?? 'N/A'; // Ajuste o campo conforme o nome no modelo
                })
                ->addColumn('nome', function ($row) {
                    return $row->cliente->nome ?? 'N/A'; // Ajuste o campo conforme o nome no modelo
                })
                ->addColumn('cor', function ($row) {
                    return $row->veiculo->cor ?? 'N/A'; // Ajuste o campo conforme o nome no modelo
                })
                ->addColumn('placa', function ($row) {
                    return $row->veiculo->placa ?? 'N/A'; // Ajuste o campo conforme o nome no modelo
                })
                ->addColumn('action', function ($row) {
                    $actionBtns = '
                    <a href="' . route("locacao.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                    
                    <form action="' . route("locacao.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-outline-danger btn-sm ml-2")><i class="fas fa-trash"></i></button>
                    </form>
                ';
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('locacoes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();

        $veiculos = Veiculo::all();

        $alugados = Locacao::select('veiculo_id', DB::raw('COUNT(veiculo_id) as total'))
            ->where('deletado', 0)
            ->whereNull('data_devolucao')
            ->groupBy('veiculo_id')
            ->get();

        $saldo_veiculos = array();

        foreach ($veiculos as $veiculo) {
            $saldo = $veiculo->saldo;

            foreach ($alugados as $alugado) {
                if ($veiculo->id == $alugado->veiculo_id) {
                    $saldo -= $alugado->total;
                }
            }
            // Apenas adiciona veículos com saldo maior que zero
            if ($saldo > 0) {
                $saldo_veiculos[] = [
                    'id' => $veiculo->id,
                    'modelo' => $veiculo->modelo,
                    'saldo' => $saldo,
                    'cor' => $veiculo->cor,
                    'placa' => $veiculo->placa,
                ];
            }
        }

       

        $output = array(
            'clientes' => $clientes,
            'veiculos' => $saldo_veiculos
        );

        return view('locacoes.crud', $output);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        
        $user = Auth::user();

        $veiculo_id = $request->veiculo_id;
        $cliente_id = $request->cliente_id;
        $data_locacao = date('Y-m-d H:i:s');
        $dias_locacao = $request->dias_locacao;
        $data_prevista_devolucao = Carbon::createFromFormat('d/m/Y', $request->data_prevista_devolucao)->format('Y-m-d');
        $origin_user = $user->name;
        $last_user = $user->name;


         // Diminui o saldo do veículo
        $veiculo = Veiculo::find($veiculo_id);
        if ($veiculo && $veiculo->saldo > 0) {
            $veiculo->saldo -= 1;
            $veiculo->save();
        }

        $loc = new Locacao();
        $loc->veiculo_id = $veiculo_id;
        $loc->cliente_id = $cliente_id;
        $loc->data_locacao = $data_locacao;
        $loc->dias_locacao = $dias_locacao;
        $loc->data_prevista_devolucao = $data_prevista_devolucao;
        $loc->origin_user = $origin_user;
        $loc->last_user = $last_user;
        $loc->save();

        // gera automaticamente a entrada financeira da locação
        // só gera o lançamento se o veiculo tiver valor de diaria configurado
        // e dias locação for nmr valido senao fica 0 ou quebrado

        if ($veiculo && $veiculo->valor_diaria && $dias_locacao) {
            $valorTotal = $veiculo->valor_diaria * $dias_locacao;

            $categoriaLocacao = CategoriaFinanceira::firstOrCreate(
                ['nome' => 'Locação', 'tipo' => 'entrada']
            );

            $lancamento = new FluxoCaixa();
            $lancamento->tipo = 'entrada';
            $lancamento->categoria_financeira_id = $categoriaLocacao->id;
            $lancamento->valor = $valorTotal;
            $lancamento->descricao = 'Locação #' . $loc->id . ' - ' . $dias_locacao . ' diária(s)';
            $lancamento->locacao_id = $loc->id;
            $lancamento->data = now();
            $lancamento->origin_user = $origin_user;
            $lancamento->last_user = $user->name;
            $lancamento->save();
        }

        return view('locacoes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $edit = Locacao::find($id);

        $clientes = Cliente::all();

        $veiculos = Veiculo::all();

        $alugados = Locacao::select('veiculo_id', DB::raw('COUNT(veiculo_id) as total'))
            ->where('deletado', 0)
            ->whereNull('data_devolucao')
            ->groupBy('veiculo_id')
            ->get();

        $saldo_veiculos = array();

          foreach ($veiculos as $veiculo) {
            $saldo = $veiculo->saldo;

            foreach ($alugados as $alugado) {
                if ($veiculo->id == $alugado->veiculo_id) {
                    $saldo -= $alugado->total;
                }
            }

            $saldo_veiculos[] = [
                'id' => $veiculo->id,
                'modelo' => $veiculo->modelo,
                'saldo' => $saldo,
                'cor' => $veiculo->cor,
                'placa' => $veiculo->placa,
            ];
        }


        $output = array(
            'clientes' => $clientes,
            'veiculos' => $saldo_veiculos,
            'edit' => $edit
        );

        return view('locacoes.crud', $output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $user = Auth::user();
        $data_devolucao = $request->data_devolucao;

        $loc = Locacao::find($id);
        $loc->data_devolucao = $data_devolucao;
        $loc->last_user = $user->name;
        $loc->update();

        // Aumenta o saldo do veículo ao devolver
        $veiculo = Veiculo::find($loc->veiculo_id);
        if ($veiculo) {
            $veiculo->saldo += 1;
            $veiculo->save();
        }


        //Ajusta o Lançamento financeiro para dias reais de uso
        // Carbon::diffInDays calcula a diferença entre as duas datas. Uso ceil()
         // (arredonda pra cima) porque mesmo uma fração de dia extra conta como
        // uma diária completa — é o padrão em locadoras reais.
        $dataLocacao = \Carbon\Carbon::parse($loc->data_locacao);
        $dataDevolucaoReal = \Carbon\Carbon::parse($data_devolucao);
        $diasReais = ceil($dataLocacao->diffInHours($dataDevolucaoReal) / 24);

        //nunca cobra menos que uma diaria msm que devolva no mesmo dia
        if ($diasReais < 1){
            $diasReais = 1;
        }

        // busca o lançamento de entrada que foi criado auto la no store
        //o lançamento vai ser alterado nao criar um nv
        $lancamentoLocacao = FluxoCaixa::where('locacao_id', $loc->id)
            ->where('categoria_financeira_id' , CategoriaFinanceira::where('nome', 'Locação')->value('id'))
            ->first();

        if ($lancamentoLocacao && $veiculo && $veiculo->valor_diaria){
            $lancamentoLocacao->valor = $veiculo->valor_diaria * $diasReais;
            $lancamentoLocacao->descricao = 'Locação #' . $loc->id . '-' . $diasReais . 'diária(s) (ajustado na devolução)';
            $lancamentoLocacao->last_user = $user->name;
            $lancamentoLocacao->save();
        }    

        //lançamento de avaria no veiculo se houver

        $valorAvaria = $request->post('valor_avaria');

        if($valorAvaria && str_replace(['.', ','], ['','.'], $valorAvaria) !== '' ){
            $valorAvariaConvertido = str_replace(['.', ','], ['','.'], $valorAvaria);

            if ($valorAvariaConvertido > 0){
                $categoriaAvaria = CategoriaFinanceira::firstOrCreate(
                    ['nome' => 'Taxa de Avaria', 'tipo' => 'entrada']
                );

                $lancamentoAvaria = new FluxoCaixa();
                $lancamentoAvaria->tipo = 'entrada';
                $lancamentoAvaria->categoria_financeira_id = $categoriaAvaria->id;
                $lancamentoAvaria->valor = $valorAvariaConvertido;
                $lancamentoAvaria->data = date('Y-m-d');
                $lancamentoAvaria->descricao = $request->post('descricao_avaria') ?: ('Avaria - Locação #' . $loc->id);
                $lancamentoAvaria->locacao_id = $loc->id;
                $lancamentoAvaria->origin_user = $user->name;
                $lancamentoAvaria->last_user = $user->name;
                $lancamentoAvaria->save();

            }
        }

        return view('locacoes.index');
    }

    
    public function destroy($id)
    {
        $user = Auth::user();
        $loc = Locacao::find($id);

        $loc->deletado = 1;
        $loc->update();

        // Remove TODOS os lançamentos financeiros vinculados a essa locação
        // (tanto o de diária quanto o de avaria, se existir) — forceDelete()
        // porque FluxoCaixa não tem soft delete, e uma locação cancelada não
        // deveria deixar resíduo nenhum no financeiro
        FluxoCaixa::where('locacao_id', $loc->id)->delete();

        return view('locacoes.index');
    }

    public function apagarTodas()
    {
        \App\Models\Locacao::query()->update(['deletado' => 1]);
        \App\Models\FluxoCaixa::wherenotNull('locacao_id')->delete();

        return response()->json(['success' => true]);
    }
}
