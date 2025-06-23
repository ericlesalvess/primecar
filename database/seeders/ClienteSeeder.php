<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nome' => 'João Silva',
                'cpf' => '123.456.789-00',
                'cep' => '01001-000',
                'logradouro' => 'Rua das Flores',
                'numero' => '123',
                'complemento' => 'Apto 12',
                'bairro' => 'Centro',
                'cidade' => 'São Paulo',
                'uf' => 'SP',
                'celular' => '(11) 91234-5678',
                'email' => 'joao.silva@email.com',
            ],
            [
                'nome' => 'Maria Oliveira',
                'cpf' => '234.567.890-11',
                'cep' => '20010-000',
                'logradouro' => 'Av. Atlântica',
                'numero' => '456',
                'complemento' => '',
                'bairro' => 'Copacabana',
                'cidade' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'celular' => '(21) 99876-5432',
                'email' => 'maria.oliveira@email.com',
            ],
            [
                'nome' => 'Carlos Souza',
                'cpf' => '345.678.901-22',
                'cep' => '30130-010',
                'logradouro' => 'Rua da Bahia',
                'numero' => '789',
                'complemento' => 'Sala 3',
                'bairro' => 'Funcionários',
                'cidade' => 'Belo Horizonte',
                'uf' => 'MG',
                'celular' => '(31) 98765-4321',
                'email' => 'carlos.souza@email.com',
            ],
            [
                'nome' => 'Ana Martins',
                'cpf' => '456.789.012-33',
                'cep' => '80010-000',
                'logradouro' => 'Av. Sete de Setembro',
                'numero' => '1001',
                'complemento' => 'Bloco B',
                'bairro' => 'Centro',
                'cidade' => 'Curitiba',
                'uf' => 'PR',
                'celular' => '(41) 98888-1111',
                'email' => 'ana.martins@email.com',
            ],
            [
                'nome' => 'Felipe Almeida',
                'cpf' => '567.890.123-44',
                'cep' => '88010-400',
                'logradouro' => 'Rua Felipe Schmidt',
                'numero' => '202',
                'complemento' => '',
                'bairro' => 'Centro',
                'cidade' => 'Florianópolis',
                'uf' => 'SC',
                'celular' => '(48) 99999-2222',
                'email' => 'felipe.almeida@email.com',
            ],
            [
                'nome' => 'Juliana Castro',
                'cpf' => '678.901.234-55',
                'cep' => '50010-000',
                'logradouro' => 'Av. Conde da Boa Vista',
                'numero' => '15',
                'complemento' => 'Apto 501',
                'bairro' => 'Boa Vista',
                'cidade' => 'Recife',
                'uf' => 'PE',
                'celular' => '(81) 91234-1111',
                'email' => 'juliana.castro@email.com',
            ],
            [
                'nome' => 'Pedro Fernandes',
                'cpf' => '789.012.345-66',
                'cep' => '64000-000',
                'logradouro' => 'Rua das Mangueiras',
                'numero' => '42',
                'complemento' => '',
                'bairro' => 'Centro',
                'cidade' => 'Teresina',
                'uf' => 'PI',
                'celular' => '(86) 92345-6789',
                'email' => 'pedro.fernandes@email.com',
            ],
            [
                'nome' => 'Larissa Lima',
                'cpf' => '890.123.456-77',
                'cep' => '69010-000',
                'logradouro' => 'Rua Eduardo Ribeiro',
                'numero' => '301',
                'complemento' => 'Loja 10',
                'bairro' => 'Centro',
                'cidade' => 'Manaus',
                'uf' => 'AM',
                'celular' => '(92) 93456-7890',
                'email' => 'larissa.lima@email.com',
            ],
            [
                'nome' => 'Renato Gomes',
                'cpf' => '901.234.567-88',
                'cep' => '72800-000',
                'logradouro' => 'Rua das Palmeiras',
                'numero' => '500',
                'complemento' => '',
                'bairro' => 'Jardim Brasília',
                'cidade' => 'Luziânia',
                'uf' => 'GO',
                'celular' => '(62) 94567-1234',
                'email' => 'renato.gomes@email.com',
            ],
            [
                'nome' => 'Camila Rocha',
                'cpf' => '012.345.678-99',
                'cep' => '66000-000',
                'logradouro' => 'Av. Nazaré',
                'numero' => '888',
                'complemento' => 'Cobertura',
                'bairro' => 'Nazaré',
                'cidade' => 'Belém',
                'uf' => 'PA',
                'celular' => '(91) 95678-3456',
                'email' => 'camila.rocha@email.com',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
