<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ram.rw'],
            [
                'name' => 'RAM Admin',
                'password' => bcrypt('ChangeMe123!'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        $this->command->info('✅ Admin user created or updated: admin@ram.rw (password: ChangeMe123!)');
    }
}
