<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanceira;
use App\Models\FluxoCaixa;
use App\Models\Locacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class FluxoCaixaController extends Controller
{

     public function index(Request $request)
    {
        if ($request->ajax()){  
            $data = FluxoCaixa::with('categoria')->latest('data')->get();
            return DataTables::of($data)
              ->addColumn('categoria_nome', function ($row){
                return $row->categoria->nome;
            })

            ->addColumn('tipo_formatado', function ($row){
                return $row->tipo === 'entrada'
                ? '<span class="badge badge-success">Entrada</span>'
                : '<span class="badge badge-danger">Saída</span>';
            })

            ->addColumn('valor_formatado', function ($row){
                return 'R$ ' .number_format($row->valor, 2, ',', '.');
            })

           ->addColumn('action', function ($row) {
                    $actionBtns = '
                        <a href="' . route("fluxo-caixa.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        

                        <form action="' . route("fluxo-caixa.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este lançamento?\')">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                    return $actionBtns;
                })

                ->rawColumns(['tipo_formatado', 'action'])
                ->make(true);

        }

         return view('fluxo-caixa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $categoriasEntrada = CategoriaFinanceira::where('tipo', 'entrada')->get();
       $categoriasSaida = CategoriaFinanceira::where('tipo', 'saida')->get();

       return view ('fluxo-caixa.crud' , compact('categoriasEntrada', 'categoriasSaida'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = Auth::user();

        $request ->validate([
            'valor' => 'required',
        ]);

        $tipo = $request->post('tipo');
        $categoria_financeira_id = $request->post('categoria_financeira_id');
        $valor = str_replace (['.',','], ['','.'], $request->post('valor'));
        $data = $request->post('data');
        $descricao = $request->post('descricao');
        $origin_user = $user->name;
        $last_user = $user->name;

        $lancamento = new FluxoCaixa();

        $lancamento->tipo = $tipo;
        $lancamento->categoria_financeira_id = $categoria_financeira_id;
        $lancamento->valor = $valor;
        $lancamento->data = $data;
        $lancamento->descricao = $descricao;
        $lancamento->origin_user = $origin_user;
        $lancamento->last_user = $last_user;

        $lancamento->save();

        return redirect()->route('fluxo-caixa.index')->with('success', 'Lançamento registrado com sucesso!');

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
        $edit = FluxoCaixa::find($id);

        $categoriasEntrada = CategoriaFinanceira::where('tipo', 'entrada')->get();
        $categoriasSaida = CategoriaFinanceira::where('tipo', 'saida')->get();

        $output = array(
            'edit' => $edit,
            'categoriasEntrada' => $categoriasEntrada,
            'categoriasSaida' => $categoriasSaida,
        );

        return view ('fluxo-caixa.crud', $output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $user = Auth::user();

    $request->validate([
        'valor' => 'required',
    ]);

    $lancamento = FluxoCaixa::find($id);
    $lancamento->tipo = $request->post('tipo');
    $lancamento->categoria_financeira_id = $request->post('categoria_financeira_id');
    $lancamento->valor = str_replace (['.',','], ['','.'], $request->post('valor'));
    $lancamento->data = $request->post('data');
    $lancamento->descricao = $request->post('descricao');
    $lancamento->last_user = $user->name;

    $lancamento->update();

    return redirect()->route('fluxo-caixa.index')->with('success', 'Lançamento atualizado com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lancamento = FluxoCaixa::find($id);
        $lancamento->delete();

        return redirect()->route('fluxo-caixa.index')->with('success', 'Lançamento excluído com sucesso!');
    }

    public function relatorios (Request $request)
    {
        // Se o usuário não escolher um ano no filtro, usamos o ano atual como padrão
        $ano = $request->get('ano', date('Y'));

        // ===== Balanço do ano: total de entradas, total de saídas, saldo =====

         // sum('valor') soma só a coluna 'valor' direto no banco (não traz os registros
         // pra PHP pra somar manualmente) — muito mais eficiente que ->get()->sum()

        $totalEntradas = FluxoCaixa::where('tipo','entrada')
            ->whereYear('data', $ano)
            ->sum('valor');

        $totalSaidas = FluxoCaixa::where('tipo','saida')
            ->whereYear('data', $ano)
            ->sum('valor');

        $saldo = $totalEntradas - $totalSaidas;


        // ======== Salto Acumulado de toda história da empresa =======
        $totalEntradasHistorico = FluxoCaixa::where('tipo','entrada')->sum('valor');
        $totalSaidasHistorico = FluxoCaixa::where('tipo','saida')->sum('valor');
        $saldoGeral = $totalEntradasHistorico - $totalSaidasHistorico;


        // ===== Faturamento mensal (só entradas, agrupado por mês) =====

        // MONTH(data) extrai só o número do mês (1 a 12) direto no SQL.
        // selectRaw permite escrever SQL puro dentro da query do Eloquent,
        // necessário aqui porque "agrupar por mês" não é algo que o Eloquent
        // tem um método pronto tipo ->groupByMonth().

        $faturamentoMensal = FluxoCaixa::selectRaw('MONTH(data) as mes, SUM(valor) as total')
            ->where('tipo','entrada')
            ->whereYear('data', $ano)
            ->groupBy('mes')
            ->orderby('mes')
            ->get();

    
         // ===== Saídas mensais (pra comparar com o faturamento, se quiser um gráfico) =====

         $saidasMensal = FluxoCaixa::selectRaw('MONTH(data) as mes, SUM(valor) as total')
            ->where('tipo','saida')
            ->whereYear('data', $ano)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();


         // ===== Lista de anos disponíveis, pra alimentar o filtro na view =====
         // DISTINCT YEAR(data) pega todos os anos diferentes que já têm lançamento,
       // sem repetir — assim o <select> de filtro só mostra anos que existem de fato

       $anosDisponiveis = FluxoCaixa::selectRaw('DISTINCT YEAR(data) as ano')
            ->orderBy('ano', 'desc')
            ->pluck('ano'); // pega a coluna ano como array simples


        // ===== Carro mais alugado (por quantidade) =====
         // where('deletado', 0) é essencial aqui: sem isso, locações "excluídas"
         // (soft delete manual do seu sistema) entrariam na contagem, inflando
         // o número de locações de um carro que teve cadastro cancelado.
        $carrosMaisAlugados = Locacao::selectRaw('veiculo_id, COUNT(*) as total_locacoes')
            ->whereYear('data_locacao', $ano)
            ->where('deletado', 0)
            ->groupBy('veiculo_id')
            ->orderByDesc('total_locacoes')
            ->with('veiculo')
            ->take(5)
            ->get();


        // ===== Cliente que mais aluga (por quantidade) =====
        $clientesQueMaisAlugam = Locacao::selectRaw('cliente_id, COUNT(*) as total_locacoes')
            ->whereYear('data_locacao', $ano)
            ->where('deletado', 0)
            ->groupby('cliente_id')
            ->orderByDesc('total_locacoes')
            ->with('cliente')
            ->take(5)
            ->get();


        // ===== Mês que mais aliga (quantidade de locação por mês) =====
        $locacoesPorMes= Locacao::selectRaw('MONTH(data_locacao) as mes, COUNT(*) as total')
            ->whereYear('data_locacao', $ano)
            ->where('deletado', 0)
            ->groupby('mes')
            ->orderBy('mes')
            ->get();    




        // ===== Carros que mais faturam =====
        // Aqui usamos JOIN (e não with()) porque queremos SOMAR o valor dos lançamentos
        // agrupando pelo veículo da locação. O caminho é:
        // fluxo_caixa -> locacoes (via locacao_id) -> veiculos (via veiculo_id)
        $faturamentoPorCarro = FluxoCaixa::join('locacoes', 'fluxo_caixa.locacao_id', '=', 'locacoes.id')
            ->join('veiculos', 'locacoes.veiculo_id', '=', 'veiculos.id')
            ->where('fluxo_caixa.tipo', 'entrada')       // só dinheiro que entrou
            ->where('locacoes.deletado', 0)              // ignora locações excluídas
            ->whereYear('fluxo_caixa.data', $ano)        // prefixo da tabela evita coluna ambígua
            ->selectRaw('veiculos.id, veiculos.modelo, veiculos.placa, SUM(fluxo_caixa.valor) as total_faturado')
            ->groupBy('veiculos.id', 'veiculos.modelo', 'veiculos.placa')
            ->orderByDesc('total_faturado')
            ->take(5)
            ->get();

        // ===== Clientes que mais faturam =====
        $faturamentoPorCliente = FluxoCaixa::join('locacoes', 'fluxo_caixa.locacao_id', '=', 'locacoes.id')
            ->join('clientes', 'locacoes.cliente_id', '=', 'clientes.id')
            ->where('fluxo_caixa.tipo', 'entrada')
            ->where('locacoes.deletado', 0)
            ->whereYear('fluxo_caixa.data', $ano)
            ->selectRaw('clientes.id, clientes.nome, SUM(fluxo_caixa.valor) as total_faturado')
            ->groupBy('clientes.id', 'clientes.nome')
            ->orderByDesc('total_faturado')
            ->take(5)
            ->get();

        


        return view('fluxo-caixa.relatorios', compact(
            'ano',
            'totalEntradas',
            'totalSaidas',
            'saldo',
            'saldoGeral',
            'faturamentoMensal',
            'saidasMensal',
            'anosDisponiveis',
            'carrosMaisAlugados',
            'clientesQueMaisAlugam',
            'locacoesPorMes',
            'faturamentoPorCarro',
            'faturamentoPorCliente'
        ));


    }
}
