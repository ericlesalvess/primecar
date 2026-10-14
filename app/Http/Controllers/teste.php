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