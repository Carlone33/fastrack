<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class RoleSeeder extends Seeder
{
    use HasRoles;
    use HasPermissions;


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrador = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor', 'guard_name' => 'web']);
        $permisologo = Role::firstOrCreate(['name' => 'Permisologo', 'guard_name' => 'web']);
        $transcriptor = Role::firstOrCreate(['name' => 'Transcriptor', 'guard_name' => 'web']);
        $superadministrador = Role::firstOrCreate(['name' => 'Superadministrador', 'guard_name' => 'web']);
        $abogado = Role::firstOrCreate(['name' => 'Abogado', 'guard_name' => 'web']);


        Permission::Create(['name' => 'Crear usuarios'])->assignRole($administrador);
        Permission::Create(['name' => 'Ver usuarios'])->syncRoles([$administrador, $supervisor]);
        Permission::Create(['name' => 'Editar usuarios'])->syncRoles([$supervisor, $administrador]);
        Permission::Create(['name' => 'Eliminar usuarios'])->assignRole($administrador);

        Permission::Create(['name' => 'Crear permisos'])->assignRole($permisologo);
        Permission::Create(['name' => 'Ver permisos'])->assignRole($permisologo);
        Permission::Create(['name' => 'Editar permisos'])->assignRole($permisologo);
        Permission::Create(['name' => 'Eliminar permisos'])->assignRole($permisologo);

        Permission::Create(['name' => 'Crear transcripciones'])->assignRole($transcriptor);

        Permission::Create(['name' => 'Ver transcripciones'])->assignRole($abogado);

        $superadministrador->syncPermissions(Permission::all());
    }
}
