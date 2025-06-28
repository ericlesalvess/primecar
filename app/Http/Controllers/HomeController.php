<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        //
        // Gera os últimos 12 meses (ex: Jul/2024 até Jun/2025)
        $labels = [];
        $data = [];
        $now = \Carbon\Carbon::now();

        for ($i = 11; $i >= 0; $i--) {
            $mes = $now->copy()->subMonths($i);
            $labels[] = $mes->format('M/Y');

            // Conta as locações do mês/ano correspondente
            $total = \App\Models\Locacao::whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            $data[] = $total;
        }

        // Gráfico de pizza: veículos mais alugados
        $veiculosMaisAlugados = \App\Models\Locacao::selectRaw('veiculo_id, COUNT(*) as total')
            ->groupBy('veiculo_id')
            ->orderByDesc('total')
            ->take(5) // Top 5 mais alugados
            ->get();

        $veiculosLabels = [];
        $veiculosData = [];

        foreach ($veiculosMaisAlugados as $item) {
            $veiculo = \App\Models\Veiculo::find($item->veiculo_id);
            $veiculosLabels[] = $veiculo ? $veiculo->modelo : 'Veículo #' . $item->veiculo_id;
            $veiculosData[] = $item->total;
        }

        // view
        return view('home', compact(
            'labels', 'data', // do gráfico de locações
            'veiculosLabels', 'veiculosData'
        ));
    }
}
