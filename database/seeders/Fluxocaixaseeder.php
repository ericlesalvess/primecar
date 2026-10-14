<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaFinanceira;
use App\Models\FluxoCaixa;
use App\Models\Veiculo;
use Carbon\Carbon;

class FluxoCaixaSeeder extends Seeder
{
    // Cache privado para armazenar categorias financeiras já buscadas/criadas, otimizando consultas ao banco
    private array $categorias = [];

    public function run(): void
    {
        // Limpa apenas os lançamentos gerados anteriormente por este seeder específico 
        // (identificados por last_user = 'Seeder' e que não possuem locação vinculada)
        FluxoCaixa::where('last_user', 'Seeder')->whereNull('locacao_id')->delete();

        // Busca todos os veículos cadastrados no banco de dados ordenados por ID
        $veiculos = Veiculo::orderBy('id')->get();

        // Validação: se não houver veículos cadastrados, exibe um aviso no console e interrompe a execução
        if ($veiculos->isEmpty()) {
            $this->command->warn('Nenhum veículo cadastrado. Cadastre o catálogo antes de rodar este seeder.');
            return;
        }

        // 1) Estrutura inicial para abrir a empresa em janeiro de 2024 (despesas de infraestrutura e lançamento)
        $estrutura = [
            ['Licenças e Documentação', 'Abertura da empresa, alvarás e registros', '2024-01-04', 3200],
            ['Instalações e Estrutura', 'Caução e 1º aluguel do pátio', '2024-01-05', 14000],
            ['Instalações e Estrutura', 'Reforma do pátio e escritório', '2024-01-08', 18000],
            ['Instalações e Estrutura', 'Móveis e equipamentos de escritório', '2024-01-10', 9500],
            ['Sistemas e Tecnologia', 'Desenvolvimento do sistema PrimeCar', '2024-01-12', 6500],
            ['Marketing', 'Campanha de lançamento da empresa', '2024-01-20', 8000],
        ];

        $totalEstrutura = 0;
        // Percorre a estrutura inicial e registra cada despesa de saída no fluxo de caixa
        foreach ($estrutura as [$categoria, $descricao, $data, $valor]) {
            $this->lancar('saida', $categoria, $valor, $data, $descricao);
            $totalEstrutura += $valor; // Acumula o custo total da estrutura
        }

        // 2) Compra dos veículos do catálogo para compor a frota (os valores se repetem ciclicamente)
        $valoresCompra = [80000, 81000, 110000, 120000, 95000, 88000];
        $frota = [];
        $totalCompras = 0;

        foreach ($veiculos as $i => $veiculo) {
            // Usa o operador módulo (%) para ciclar pelos valores de compra caso a frota seja maior que o array
            $valor = $valoresCompra[$i % count($valoresCompra)];
            $nome = $this->nome($veiculo); // Gera o nome formatado do veículo (ex: "Kicks Verde")

            // Lança a saída referente à compra do veículo, espaçando as datas em 2 dias a partir de 15/01/2024
            $this->lancar('saida', 'Compra de Veículo', $valor, Carbon::create(2024, 1, 15)->addDays($i * 2), $nome);

            $frota[] = ['nome' => $nome, 'valor' => $valor]; // Adiciona o veículo ao array auxiliar da frota
            $totalCompras += $valor; // Acumula o valor total investido na compra dos veículos
        }

        // 3) Investimento inicial (aporte dos sócios): cobre estrutura + frota + R$ 300 mil de capital de giro, arredondado para cima na centena de milhar
        $aporte = ceil(($totalEstrutura + $totalCompras + 300000) / 100000) * 100000;
        $this->lancar('entrada', 'Investimento', $aporte, '2024-01-02', 'Investimento Inicial');

        // 4) Rotina mensal recorrente, executada de janeiro/2024 até o último mês fechado
        $mes = Carbon::create(2024, 1, 1);
        $fim = Carbon::today()->startOfMonth()->subMonth();
        $i = 0; // Contador de meses desde a abertura (usado para modular variações de valores sem uso de rand)

        while ($mes->lte($fim)) {
            $ref = $mes->format('m/Y'); // Formato mês/ano para as descrições (ex: "01/2024")
            $ano = $mes->year; // Ano atual do loop
            $dia = fn (int $d) => $mes->copy()->day($d); // Função auxiliar para definir um dia específico no mês corrente
            $reajuste = 1 + 0.06 * ($ano - 2024); // Aplicação de reajuste inflacionário estimado de ~6% ao ano

            // --- Despesas Fixas Mensais ---
            $this->lancar('saida', 'Aluguel do Pátio', 3500 * $reajuste, $dia(5), "Aluguel do pátio - $ref");
            $this->lancar('saida', 'Internet e Telefonia', 189.90, $dia(10), "Internet e telefonia - $ref");
            $this->lancar('saida', 'Contabilidade', 900 * $reajuste, $dia(10), "Honorários contábeis - $ref");

            // --- Despesas Variáveis Mensais (com variação matemática controlada pelo índice $i) ---
            $this->lancar('saida', 'Luz', 420 + ($i % 6) * 45, $dia(12), "Conta de luz - $ref");
            $this->lancar('saida', 'Agua', 130 + ($i % 4) * 25, $dia(12), "Conta de água - $ref");
            $this->lancar('saida', 'Marketing', 400 + ($i % 3) * 300, $dia(15), "Anúncios e divulgação - $ref");

            // --- Custos de Equipe e Frota (a partir do 2º mês / $i >= 1) ---
            if ($i >= 1) {
                $this->lancar('saida', 'Salário', 7500 * $reajuste, $dia(5), "Folha de pagamento - $ref");
                $this->lancar('saida', 'Encargos e Benefícios', 2400 * $reajuste, $dia(20), "Encargos e benefícios - $ref");
                $this->lancar('saida', 'Seguro da Frota', $totalCompras * 0.045 / 12, $dia(8), "Seguro da frota - $ref");
                $this->lancar('saida', 'Lavagem e Higienização', count($frota) * 45, $dia(28), "Lavagem da frota - $ref");
            }

            // --- Impostos e Rendimentos Financeiros (a partir de março/2024 / $i >= 2) ---
            if ($i >= 2) {
                $this->lancar('saida', 'Impostos', 1500 + $i * 40, $dia(20), "Simples Nacional - $ref");
                $this->lancar('entrada', 'Rendimentos Financeiros', 400 + $i * 30, $dia(28), "Rendimento da aplicação - $ref");
            }

            // --- Pró-labore dos Sócios (a partir de julho/2024) ---
            if ($mes->gte(Carbon::create(2024, 7, 1))) {
                $this->lancar('saida', 'Retirada de Sócios', 4000 + ($ano - 2024) * 500, $dia(28), "Pró-labore dos sócios - $ref");
            }

            // --- Manutenção de Veículos (itera ciclicamente um veículo da frota a cada dois meses) ---
            if ($i % 2 == 0) {
                $f = $frota[$i % count($frota)];
                $this->lancar('saida', 'Manutenção do Veículo', 250 + ($i % 5) * 380, $dia(18), "Manutenção - {$f['nome']}");
            }

            // --- Multas de Trânsito Esporádicas ---
            if ($i % 5 == 3) {
                $this->lancar('saida', 'Multas e Taxas', 130 + ($i % 3) * 60, $dia(22), "Multa de trânsito - $ref");
            }

            // --- Pagamento de IPVA (cobrado em março de 2024 no primeiro ano e em janeiro nos anos seguintes) ---
            if (($ano == 2024 && $mes->month == 3) || ($ano > 2024 && $mes->month == 1)) {
                foreach ($frota as $f) {
                    $this->lancar('saida', 'IPVA', $f['valor'] * 0.03, $dia(15), "IPVA $ano - {$f['nome']}");
                }
            }

            // Avança para o próximo mês e incrementa o contador de controle
            $mes->addMonth();
            $i++;
        }
    }

    /**
     * Busca a categoria financeira pelo nome em cache ou no banco de dados. 
     * Se não existir, cria um novo registro (reaproveitando categorias existentes).
     */
    private function categoria(string $nome, string $tipo): int
    {
        return $this->categorias[$nome] ??= CategoriaFinanceira::firstOrCreate(
            ['nome' => $nome, 'tipo' => $tipo]
        )->id;
    }

    /**
     * Cria o registro no fluxo de caixa. O uso de forceCreate ignora restrições do $fillable do Model.
     */
    private function lancar(string $tipo, string $categoria, float $valor, $data, string $descricao): void
    {
        FluxoCaixa::forceCreate([
            'tipo' => $tipo,
            'categoria_financeira_id' => $this->categoria($categoria, $tipo),
            'valor' => round($valor, 2),
            'data' => Carbon::parse($data)->toDateString(),
            'descricao' => $descricao,
            'origin_user' => 'Administrador',
            'last_user' => 'Seeder',
        ]);
    }

    /**
     * Retorna o nome formatado do veículo concatenando o modelo e a cor (ex: "Kicks Verde").
     */
    private function nome($veiculo): string
    {
        return trim($veiculo->modelo . ' ' . $veiculo->cor);
    }
}