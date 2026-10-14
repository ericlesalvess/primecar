<?php

namespace Database\Seeders;

use App\Models\CategoriaFinanceira;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaFinanceiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // updateOrCreate evita duplicar categorias se você rodar o seeder mais de uma vez
         $categorias = [
            ['nome' => 'Locação',                     'tipo' =>'entrada'],
            ['nome' => 'Venda de Veículo',            'tipo' =>'entrada'],
            ['nome' => 'Investimento',                'tipo' => 'entrada'],
            ['nome' => 'Taxa de Avaria',             'tipo' => 'entrada'],
            ['nome' => 'Outras Entradas',             'tipo' => 'entrada'],

            
            ['nome' => 'Compra de Veículo',           'tipo' =>'saida'],
            ['nome' => 'Luz',                        'tipo' => 'saida'],
            ['nome' => 'Agua',                       'tipo' => 'saida'],
            ['nome' => 'Internet/Telefone',          'tipo' => 'saida'],
            ['nome' => 'Aluguel',                    'tipo' => 'saida'],
            ['nome' => 'Manutenção do Veículo',      'tipo' => 'saida'],
            ['nome' => 'Combustível',                'tipo' => 'saida'],
            ['nome' => 'IPVA',                       'tipo' => 'saida'],
            ['nome' => 'Salário',                    'tipo' => 'saida'],
            ['nome' => 'Outras Saídas',              'tipo' => 'saida'],
         ];

         foreach ($categorias as $categoria) {
            CategoriaFinanceira::updateOrCreate(
                ['nome' => $categoria['nome']],  // condição de busca
                $categoria                     // dados para criar/ atualizar
            );
    }
}
}