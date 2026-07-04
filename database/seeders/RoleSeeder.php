<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions (all the actions you need)
        $permissions = [
            'view dashboard',
            'manage projects',
            'manage contracts',
            'manage variations',
            'manage payments',
            'manage procurement',
            'manage documents',
            'manage reports',
            'manage users',
            'view activity logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'Administrator']);
        $admin->givePermissionTo(Permission::all());

        $commercialManager = Role::create(['name' => 'Commercial Manager']);
        $commercialManager->givePermissionTo([
            'view dashboard',
            'manage projects',
            'manage contracts',
            'manage variations',
            'manage payments',
            'manage procurement',
            'manage documents',
            'manage reports',
            'view activity logs',
        ]);

        $projectManager = Role::create(['name' => 'Project Manager']);
        $projectManager->givePermissionTo([
            'view dashboard',
            'manage projects',
            'manage contracts',
            'manage variations',
            'manage payments',
            'manage documents',
            'view activity logs',
        ]);

        $quantitySurveyor = Role::create(['name' => 'Quantity Surveyor']);
        $quantitySurveyor->givePermissionTo([
            'view dashboard',
            'manage contracts',
            'manage variations',
            'manage payments',
            'manage documents',
        ]);

        $procurementOfficer = Role::create(['name' => 'Procurement Officer']);
        $procurementOfficer->givePermissionTo([
            'view dashboard',
            'manage procurement',
            'manage documents',
        ]);

        $finance = Role::create(['name' => 'Finance']);
        $finance->givePermissionTo([
            'view dashboard',
            'manage payments',
            'manage reports',
        ]);

        $documentController = Role::create(['name' => 'Document Controller']);
        $documentController->givePermissionTo([
            'view dashboard',
            'manage documents',
        ]);

        $client = Role::create(['name' => 'Client']);
        $client->givePermissionTo([
            'view dashboard',
            'view activity logs',
        ]);
    }
}