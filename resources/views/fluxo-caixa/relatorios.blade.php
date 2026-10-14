@extends('adminlte::page')

@section('title', 'Relatórios - Fluxo de Caixa')

@section('content_header')
@stop

@section('plugins.Chartjs', true)

@section('content')

    {{-- Filtro de ano --}}
    <div class="row mb-3">
        <div class="col-sm-3">
            <form method="get" action="{{ route('fluxo-caixa.relatorios') }}">
                <select name="ano" class="form-control" onchange="this.form.submit()">
                    @foreach ($anosDisponiveis as $anoDisponivel)
                        <option value="{{ $anoDisponivel }}" {{ $anoDisponivel == $ano ? 'selected' : '' }}>
                            {{ $anoDisponivel }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    {{-- Cards de resumo: entradas, saídas e saldo --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>R$ {{ number_format($totalEntradas, 2, ',', '.') }}</h3>
                    <p>Total de Entradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>R$ {{ number_format($totalSaidas, 2, ',', '.') }}</h3>
                    <p>Total de Saídas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box {{ $saldo >= 0 ? 'bg-info' : 'bg-warning' }}">
                <div class="inner">
                    <h3>R$ {{ number_format($saldo, 2, ',', '.') }}</h3>
                    <p>Saldo do Período ({{ $saldo >= 0 ? 'Positivo' : 'Negativo' }})</p>
                </div>
                <div class="icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
            </div>
        </div>
        {{-- Saldo Geral Acumulado --}}
        <div class="col-lg-3 col-6">
            <div class="small-box {{ $saldoGeral >= 0 ? 'bg-primary' : 'bg-danger' }}">
                <div class="inner">
                    <h3>R$ {{ number_format($saldoGeral, 2, ',', '.') }}</h3>
                    <p>Saldo Geral (Acumulado)</p>
                </div>
                <div class="icon"><i class="fas fa-wallet"></i></div>
            </div>
        </div>
    </div>

    {{-- Gráfico comparando faturamento x saídas, mês a mês --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Entradas x Saídas Mensais - {{ $ano }}</h3>
        </div>
        <div class="card-body">
            <canvas id="graficoMensal" style="min-height: 300px;"></canvas>
        </div>
    </div>

    {{-- Rankings por quantidade de locações --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Carros Mais Alugados - {{ $ano }}</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Veículo</th>
                                <th class="text-right">Locações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($carrosMaisAlugados as $item)
                                <tr>
                                    <td>{{ optional($item->veiculo)->modelo ?? 'Veículo removido' }}</td>
                                    <td class="text-right">{{ $item->total_locacoes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Nenhuma locação neste período</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Clientes que Mais Alugam - {{ $ano }}</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th class="text-right">Locações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientesQueMaisAlugam as $item)
                                <tr>
                                    <td>{{ optional($item->cliente)->nome ?? 'Cliente removido' }}</td>
                                    <td class="text-right">{{ $item->total_locacoes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Nenhuma locação neste período</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Rankings por faturamento --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Carros que Mais Faturam - {{ $ano }}</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Veículo</th>
                                <th class="text-right">Faturamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faturamentoPorCarro as $item)
                                <tr>
                                    <td>{{ $item->modelo }} <small class="text-muted">({{ $item->placa }})</small></td>
                                    <td class="text-right">R$ {{ number_format($item->total_faturado, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Nenhum faturamento neste período</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Clientes que Mais Faturam - {{ $ano }}</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th class="text-right">Faturamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faturamentoPorCliente as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>
                                    <td class="text-right">R$ {{ number_format($item->total_faturado, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Nenhum faturamento neste período</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráfico de locações por mês --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Locações por Mês - {{ $ano }}</h3>
        </div>
        <div class="card-body">
            <canvas id="graficoLocacoesMes" style="min-height: 250px;"></canvas>
        </div>
    </div>

@stop

@section('js')
    <script>
        $(document).ready(function () {

            var nomesMeses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

            // ===== Gráfico Mensal (Entradas x Saídas) =====
            var faturamentoPorMes = @json($faturamentoMensal->pluck('total', 'mes'));
            var saidasPorMes = @json($saidasMensal->pluck('total', 'mes'));

            var dadosEntradas = [];
            var dadosSaidas = [];

            for (var mes = 1; mes <= 12; mes++) {
                dadosEntradas.push(faturamentoPorMes[mes] || 0);
                dadosSaidas.push(saidasPorMes[mes] || 0);
            }

            var ctx = document.getElementById('graficoMensal').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nomesMeses,
                    datasets: [
                        {
                            label: 'Entradas',
                            data: dadosEntradas,
                            backgroundColor: 'rgba(40, 167, 69, 0.7)'
                        },
                        {
                            label: 'Saídas',
                            data: dadosSaidas,
                            backgroundColor: 'rgba(220, 53, 69, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function (value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR');
                                }
                            }
                        }]
                    }
                }
            });

            // ===== Gráfico de Locações por Mês =====
            var locacoesPorMesData = @json($locacoesPorMes->pluck('total', 'mes'));

            var dadosLocacoes = [];
            for (var mes = 1; mes <= 12; mes++) {
                dadosLocacoes.push(locacoesPorMesData[mes] || 0);
            }

            var ctxLocacoes = document.getElementById('graficoLocacoesMes').getContext('2d');

            new Chart(ctxLocacoes, {
                type: 'bar',
                data: {
                    labels: nomesMeses,
                    datasets: [
                        {
                            label: 'Locações',
                            data: dadosLocacoes,
                            backgroundColor: 'rgba(23, 162, 184, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function (value) {
                                    return Number.isInteger(value) ? value : null;
                                }
                            }
                        }]
                    }
                }
            });

        });
    </script>
@stop