@extends('adminlte::page')

@section('title', 'Painel de Controle')

@section('content_header')
    <h1>Painel de Controle</h1>
@stop

@section('content')
<div class="row min-vh-100 align-items-stretch">
    <div class="col-md-12">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                        <!-- Botão para mostrar gráfico de locações -->
                        <button id="showLocacoesChart" class="btn btn-outline-primary mb-3">
                            <i class="fas fa-chart-line"></i> Ver Gráfico de Locações
                        </button>
                        <div id="locacoesChartContainer" style="width: 100%; max-width: 500px; height:300px; display: none;">
                            <canvas id="locacoesChart" height="180"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                        <!-- Botão para mostrar gráfico de veículos -->
                        <button id="showVeiculosChart" class="btn btn-outline-success mb-3">
                            <i class="fas fa-chart-pie"></i> Ver Gráfico de Veículos
                        </button>
                        <div id="veiculosChartContainer" style="width: 100%; max-width: 350px; display: none;">
                            <canvas id="veiculosPieChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1"></div>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Botões para mostrar os gráficos
    document.getElementById('showLocacoesChart').onclick = function() {
        document.getElementById('locacoesChartContainer').style.display = 'block';
        this.style.display = 'none';
    };
    document.getElementById('showVeiculosChart').onclick = function() {
        document.getElementById('veiculosChartContainer').style.display = 'block';
        this.style.display = 'none';
    };

    const labels = {!! json_encode($labels) !!};
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Locações',
                data: {!! json_encode($data) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                fill: false,
                tension: 0.1
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Locações dos últimos 12 meses'
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    new Chart(document.getElementById('locacoesChart'), config);

    // Gráfico de pizza dos veículos mais alugados
    const veiculosPieLabels = {!! json_encode($veiculosLabels) !!};
    const veiculosPieData = {!! json_encode($veiculosData) !!};

    new Chart(document.getElementById('veiculosPieChart'), {
        type: 'pie',
        data: {
            labels: veiculosPieLabels,
            datasets: [{
                data: veiculosPieData,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ]
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Veículos mais alugados'
                }
            }
        }
    });
});
</script>
@endpush
