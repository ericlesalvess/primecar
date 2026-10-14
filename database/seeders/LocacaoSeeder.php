<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaFinanceira;
use App\Models\Cliente;
use App\Models\FluxoCaixa;
use App\Models\Locacao;
use App\Models\Veiculo;
use Carbon\Carbon;

class LocacaoSeeder extends Seeder
{
    public function run(): void
    {
        // Rodar de novo apaga só o que este seeder criou (last_user = 'Seeder'):
        // primeiro os lançamentos (que apontam para a locação), depois as locações.
        $antigas = Locacao::where('last_user', 'Seeder')->pluck('id');
        FluxoCaixa::whereIn('locacao_id', $antigas)->delete();
        Locacao::whereIn('id', $antigas)->delete();

        $veiculos = Veiculo::orderBy('id')->get();
        $clientes = Cliente::orderBy('id')->pluck('id')->values();

        if ($veiculos->isEmpty() || $clientes->isEmpty()) {
            $this->command->warn('Precisa de veículos e clientes cadastrados antes de gerar locações.');
            return;
        }

        $categoriaLocacao = CategoriaFinanceira::firstOrCreate(['nome' => 'Locação', 'tipo' => 'entrada'])->id;
        $categoriaAvaria = CategoriaFinanceira::firstOrCreate(['nome' => 'Taxa de Avaria', 'tipo' => 'entrada'])->id;

        $diasPossiveis = [3, 5, 7, 2, 10, 4, 15, 7, 3, 30, 5, 1]; // duração de cada locação, em ciclo
        $intervalos = [3, 6, 9, 5, 12, 4, 8];                      // dias parado entre uma locação e outra
        $hoje = Carbon::today();
        $total = 0; // contador geral, usado para escolher o cliente

        foreach ($veiculos as $i => $veiculo) {
            // Usa a diária cadastrada; se estiver vazia, inventa uma diferente para cada veículo
            $diaria = $veiculo->valor_diaria ?: (150 + $i * 25);

            // Cada veículo começa alguns dias depois do anterior (todos já comprados em jan/2024)
            $data = Carbon::create(2024, 2, 1)->addDays($i * 3);
            $k = $i; // varia os padrões entre veículos

            while (true) {
                $dias = $diasPossiveis[$k % count($diasPossiveis)];
                $atraso = ($k % 7 == 3) ? 2 : 0; // 1 a cada 7 locações volta com atraso
                $prevista = $data->copy()->addDays($dias);
                $devolucao = $prevista->copy()->addDays($atraso);

                // Se ainda não foi devolvida, fica em aberto (sem data_devolucao)
                $aberta = $devolucao->gte($hoje);
                if ($aberta && $data->gt($hoje)) {
                    break; // começaria no futuro
                }
                if ($aberta) {
                    $atraso = 0;
                }

                // Alguns clientes alugam mais que outros, para os relatórios ficarem interessantes
                $indice = ($total % 4 == 0) ? ($total % 2) : ($total % $clientes->count());

                $locacao = Locacao::forceCreate([
                    'veiculo_id' => $veiculo->id,
                    'cliente_id' => $clientes[$indice],
                    'data_locacao' => $data->toDateString(),
                    'dias_locacao' => $dias,
                    'data_prevista_devolucao' => $prevista->toDateString(),
                    'data_devolucao' => $aberta ? null : $devolucao->toDateString(),
                    'deletado' => 0,
                    'origin_user' => 'Administrador',
                    'last_user' => 'Seeder',
                ]);

                // Cobrança no fechamento da locação, ajustada para os dias reais quando já devolvida
                $diasCobrados = $dias + $atraso;
                FluxoCaixa::forceCreate([
                    'tipo' => 'entrada',
                    'categoria_financeira_id' => $categoriaLocacao,
                    'valor' => $diaria * $diasCobrados,
                    'data' => $data->toDateString(),
                    'descricao' => 'Locação #' . $locacao->id . ' - ' . $diasCobrados . ' diária(s)',
                    'locacao_id' => $locacao->id,
                    'origin_user' => 'Administrador',
                    'last_user' => 'Seeder',
                ]);

                // Avaria na devolução: 1 a cada 9 locações já devolvidas
                if (!$aberta && $k % 9 == 4) {
                    FluxoCaixa::forceCreate([
                        'tipo' => 'entrada',
                        'categoria_financeira_id' => $categoriaAvaria,
                        'valor' => 400 + ($k % 4) * 250,
                        'data' => $devolucao->toDateString(),
                        'descricao' => 'Avaria na devolução - Locação #' . $locacao->id,
                        'locacao_id' => $locacao->id,
                        'origin_user' => 'Administrador',
                        'last_user' => 'Seeder',
                    ]);
                }

                $total++;

                if ($aberta) {
                    break;
                }

                // Próxima locação: depois da devolução + um intervalo (alguns veículos ficam mais parados)
                $data = $devolucao->copy()->addDays($intervalos[$k % count($intervalos)] + ($i % 3) * 3);
                $k++;
            }
        }

        // Atualiza a coluna saldo de cada veículo (1 = disponível, 0 = alugado),
        // usando o próprio cálculo do model, que olha as locações em aberto.
        foreach (Veiculo::all() as $veiculo) {
            $veiculo->update(['saldo' => $veiculo->saldo]);
        }

        $this->command->info("$total locações criadas, com os lançamentos de entrada vinculados.");
    }
}