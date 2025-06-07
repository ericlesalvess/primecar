<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache de permissões
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Lista de permissões
        $permissoes = [
            'acessar cadastro',
            'acessar dashboard',
            'acessar catalogo',
            'acessar locacao',
            'acessar cliente',
            'acessar veiculo',
        ];

        // Criar as permissões com o guard explícito
        foreach ($permissoes as $permissao) {
            Permission::firstOrCreate(
                ['name' => $permissao, 'guard_name' => 'web']
            );
        }

        // Criar papéis
        $admin       = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $cliente     = Role::firstOrCreate(['name' => 'cliente', 'guard_name' => 'web']);
        $funcionario = Role::firstOrCreate(['name' => 'funcionario', 'guard_name' => 'web']);
        $vendedor    = Role::firstOrCreate(['name' => 'vendedor', 'guard_name' => 'web']);

        // Atribuir permissões por papel
        $admin->givePermissionTo(Permission::all());

        $cliente->syncPermissions([
            'acessar catalogo',
        ]);

        $funcionario->syncPermissions([
            'acessar cadastro',
            'acessar cliente',
            'acessar veiculo',
        ]);

        $vendedor->syncPermissions([
            'acessar catalogo',
            'acessar locacao',
        ]);
    }
}
