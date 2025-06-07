<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        
        // Usuario Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@teste.com'],
                [
                    'name' => 'Administrador',
                    'email_verified_at' => now(),
                    'password' => bcrypt('12345678')
                ]
        );
        // Atribui o papel de admin ao usuário
        $admin->assignRole('admin');


        // Usuario Funcionario
        $funcionario = User::firstOrCreate(
            ['email' => 'funcionario@teste.com'],
                [
                    'name' => 'Funcionario',
                    'email_verified_at' => now(),
                    'password' => bcrypt('12345678')
                ]
        );

        $funcionario->assignRole('funcionario');
        

        // Usuario Vendedor
          $vendedor = User::firstOrCreate(
            ['email' => 'vendedor@teste.com'],
                [
                    'name' => 'Vendedor',
                    'email_verified_at' => now(),
                     'password' => bcrypt('12345678')
                ]
        );
        // Atribui o papel de vendedor ao vendedor
        $vendedor->assignRole('vendedor');
        

        // Usuario Cliente
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@teste.com'],
                [
                    'name' => 'Cliente',
                    'email_verified_at' => now(),
                    'password' => bcrypt('12345678')
                ]
        );
        // Atribui o papel de cliente ao cliente
        $cliente->assignRole('cliente');
    }
}
