<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list achievments']);
        Permission::create(['name' => 'view achievments']);
        Permission::create(['name' => 'list dataachievments']);
        Permission::create(['name' => 'view dataachievments']);
        Permission::create(['name' => 'list datatasks']);
        Permission::create(['name' => 'view datatasks']);
        Permission::create(['name' => 'list dataviolations']);
        Permission::create(['name' => 'view dataviolations']);
        Permission::create(['name' => 'view students']);
        Permission::create(['name' => 'list tasks']);
        Permission::create(['name' => 'view tasks']);
        Permission::create(['name' => 'list violations']);
        Permission::create(['name' => 'view violations']);
        Permission::create(['name' => 'list articles']);
        Permission::create(['name' => 'view articles']);
        Permission::create(['name' => 'list quotes']);
        Permission::create(['name' => 'view quotes']);
        // membuat role siswa dan asign permission
        $studentPermissions = Permission::all();
        $siswaRole = Role::create(['name' => 'siswa']);
        $siswaRole->givePermissionTo($studentPermissions);

        Permission::create(['name' => 'create dataachievments']);
        Permission::create(['name' => 'create datatasks']);
        Permission::create(['name' => 'create dataviolations']);
        Permission::create(['name' => 'list historyachievments']);
        Permission::create(['name' => 'view historyachievments']);
        Permission::create(['name' => 'create historyachievments']);
        Permission::create(['name' => 'list historytasks']);
        Permission::create(['name' => 'view historytasks']);
        Permission::create(['name' => 'create historytasks']);
        Permission::create(['name' => 'list historyviolations']);
        Permission::create(['name' => 'view historyviolations']);
        Permission::create(['name' => 'create historyviolations']);
        Permission::create(['name' => 'view teachers']);
        // membuat role guru dan asign permission
        $teacherPermission = Permission::all();
        $teacherRole = Role::create(['name' => 'guru-mapel']);
        $teacherRole->givePermissionTo($teacherPermission);

        Permission::create(['name' => 'list students']);
        Permission::create(['name' => 'list presences']);
        Permission::create(['name' => 'list studentabsences']);
        Permission::create(['name' => 'view studentabsences']);
        Permission::create(['name' => 'create studentabsences']);
        // membuat role wali-kelas dan asign permission
        $homeroomPermission = Permission::all();
        $homeroomRole = Role::create(['name' => 'wali-kelas']);
        $homeroomRole->givePermissionTo($homeroomPermission);
        
        Permission::create(['name' => 'create articles']);
        Permission::create(['name' => 'update articles']);
        Permission::create(['name' => 'delete articles']);

        Permission::create(['name' => 'create quotes']);
        Permission::create(['name' => 'update quotes']);
        Permission::create(['name' => 'delete quotes']);

        Permission::create(['name' => 'create achievments']);
        Permission::create(['name' => 'update achievments']);
        Permission::create(['name' => 'delete achievments']);

        Permission::create(['name' => 'list classstudents']);
        Permission::create(['name' => 'view classstudents']);
        Permission::create(['name' => 'create classstudents']);
        Permission::create(['name' => 'update classstudents']);
        Permission::create(['name' => 'delete classstudents']);


        Permission::create(['name' => 'view presences']);
        Permission::create(['name' => 'create presences']);
        Permission::create(['name' => 'update presences']);
        Permission::create(['name' => 'delete presences']);

        Permission::create(['name' => 'update studentabsences']);
        Permission::create(['name' => 'delete studentabsences']);   

        Permission::create(['name' => 'update dataachievments']);
        Permission::create(['name' => 'delete dataachievments']);

        Permission::create(['name' => 'update datatasks']);
        Permission::create(['name' => 'delete datatasks']);

        Permission::create(['name' => 'update dataviolations']);
        Permission::create(['name' => 'delete dataviolations']);

        Permission::create(['name' => 'update historyachievments']);
        Permission::create(['name' => 'delete historyachievments']);

        Permission::create(['name' => 'update historytasks']);
        Permission::create(['name' => 'delete historytasks']);

        Permission::create(['name' => 'update historyviolations']);
        Permission::create(['name' => 'delete historyviolations']);

        Permission::create(['name' => 'list homerooms']);
        Permission::create(['name' => 'view homerooms']);
        Permission::create(['name' => 'create homerooms']);
        Permission::create(['name' => 'update homerooms']);
        Permission::create(['name' => 'delete homerooms']);

        Permission::create(['name' => 'create students']);
        Permission::create(['name' => 'update students']);
        Permission::create(['name' => 'delete students']);

        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'update tasks']);
        Permission::create(['name' => 'delete tasks']);

        Permission::create(['name' => 'list teachers']);
        Permission::create(['name' => 'create teachers']);
        Permission::create(['name' => 'update teachers']);
        Permission::create(['name' => 'delete teachers']);

        Permission::create(['name' => 'create violations']);
        Permission::create(['name' => 'update violations']);
        Permission::create(['name' => 'delete violations']);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('adminzie@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}