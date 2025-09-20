<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(UserRoleSeeder::class);
        $this->call(AdminUserSeeder::class);


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }


}


class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'super-admin','guard_name' => 'web'],
            ['name' => 'agent','guard_name' => 'web'],
        ]);
    }
}

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve the "super-admin" role
        $superAdminRole = Role::where('name', 'super-admin')->firstOrFail();
        $superAdminRole->syncPermissions(Permission::all());
        // Create the admin user
        User::create([
            'name' => 'Super Admin',
            'email' => 'SuperAdmin@dev.com',
            'code' =>   0000,
            'joining_date' =>   '1/17/2025',
            'password' => bcrypt('123456'),
        ])->assignRole($superAdminRole);
    }
}

