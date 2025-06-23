<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Veiculo;

class VeiculoSeeder extends Seeder
{
    public function run(): void
    {
        $veiculos = [
            [
                'modelo' => 'Honda Civic',
                'marca' => 'Honda',
                'placa' => 'APC-1454',
                'renavam' => '123456289',
                'chassi' => '9BWZZZ377VT004251',
                'ano_fabricacao' => 2020,
                'cor' => 'Preto',
                'tipo_combustivel' => 'Gasolina',
                'origem' => '0',
            ],
            [
                'modelo' => 'Toyota Corolla',
                'marca' => 'Toyota',
                'placa' => 'DEF-5678',
                'renavam' => '234567891',
                'chassi' => '8ADZZW55VLL001234',
                'ano_fabricacao' => 2019,
                'cor' => 'Branco',
                'tipo_combustivel' => 'Flex',
                'origem' => '1',
            ],
            [
                'modelo' => 'Chevrolet Onix',
                'marca' => 'Chevrolet',
                'placa' => 'GHI-9101',
                'renavam' => '345678912',
                'chassi' => '9BGKS48U0EG109876',
                'ano_fabricacao' => 2018,
                'cor' => 'Vermelho',
                'tipo_combustivel' => 'Álcool',
                'origem' => '0',
            ],
            [
                'modelo' => 'Ford Ranger',
                'marca' => 'Ford',
                'placa' => 'JKL-2345',
                'renavam' => '456789123',
                'chassi' => '1FTNE24L6VHB21234',
                'ano_fabricacao' => 2021,
                'cor' => 'Azul',
                'tipo_combustivel' => 'Diesel',
                'origem' => '0',
            ],
            [
                'modelo' => 'Hyundai Elantra',
                'marca' => 'Hyundai',
                'placa' => 'MNO-6789',
                'renavam' => '567891234',
                'chassi' => 'KMHDH41F7BU612345',
                'ano_fabricacao' => 2020,
                'cor' => 'Prata',
                'tipo_combustivel' => 'Gás',
                'origem' => '1',
            ],
            [
                'modelo' => 'Volkswagen Gol',
                'marca' => 'Volkswagen',
                'placa' => 'PQR-1011',
                'renavam' => '678912345',
                'chassi' => '9BWZZZ377VT017890',
                'ano_fabricacao' => 2017,
                'cor' => 'Cinza',
                'tipo_combustivel' => 'Flex',
                'origem' => '0',
            ],
            [
                'modelo' => 'Nissan Kicks',
                'marca' => 'Nissan',
                'placa' => 'STU-1213',
                'renavam' => '789123456',
                'chassi' => '3N1CP5CU7KL123456',
                'ano_fabricacao' => 2019,
                'cor' => 'Verde',
                'tipo_combustivel' => 'Gasolina',
                'origem' => '1',
            ],
            [
                'modelo' => 'Fiat Strada',
                'marca' => 'Fiat',
                'placa' => 'VWX-1415',
                'renavam' => '891234567',
                'chassi' => '9BD17113GLC123456',
                'ano_fabricacao' => 2022,
                'cor' => 'Preto',
                'tipo_combustivel' => 'Flex',
                'origem' => '0',
            ],
            [
                'modelo' => 'Renault Sandero',
                'marca' => 'Renault',
                'placa' => 'YZA-1617',
                'renavam' => '912345678',
                'chassi' => '93YBBWR1J9J123456',
                'ano_fabricacao' => 2016,
                'cor' => 'Azul',
                'tipo_combustivel' => 'Álcool',
                'origem' => '0',
            ],
            [
                'modelo' => 'Kia Sportage',
                'marca' => 'Kia',
                'placa' => 'BCD-1819',
                'renavam' => '102345678',
                'chassi' => 'KNDPBCA24L7012345',
                'ano_fabricacao' => 2018,
                'cor' => 'Marrom',
                'tipo_combustivel' => 'Diesel',
                'origem' => '1',
            ],
        ];

        foreach ($veiculos as $veiculo) {
            Veiculo::create($veiculo);
        }
    }
}
