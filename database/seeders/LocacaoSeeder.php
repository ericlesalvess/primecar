<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locacao;
use App\Models\Cliente;
use App\Models\Veiculo;
use Carbon\Carbon;

class LocacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = \App\Models\Cliente::pluck('id')->all();
        $veiculos = \App\Models\Veiculo::pluck('id')->all();

        $now = Carbon::now();

        // Para cada um dos últimos 12 meses
        for ($i = 0; $i < 12; $i++) {
            $dataMes = $now->copy()->subMonths($i)->startOfMonth();
            // Gera uma quantidade aleatória de locações para o mês (entre 2 e 10)
            $qtd = rand(2, 10);

            for ($j = 0; $j < $qtd; $j++) {
                Locacao::create([
                    'cliente_id' => $clientes[array_rand($clientes)],
                    'veiculo_id' => $veiculos[array_rand($veiculos)],
                    'data_locacao' => $dataMes->copy()->addDays(rand(0, 27)),
                    'created_at' => $dataMes->copy()->addDays(rand(0, 27)),
                    'updated_at' => $dataMes->copy()->addDays(rand(0, 27)),
                    // outros campos obrigatórios...
                ]);
            }
        }
    }
}
