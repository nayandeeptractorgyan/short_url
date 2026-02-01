<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $now = now()->format('Y-m-d H:i:s');
        $password = Hash::make('password');

        DB::statement(
            "INSERT INTO users (name, email, password, role, company_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)",
            ['Super Admin', 'superadmin@example.com', $password, 'super_admin', null, $now, $now]
        );
    }
}
