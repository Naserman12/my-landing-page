<?php
namespace Database\Seeders;

use App\Models\User;
// use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء الأدوار
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            ])->assignRole('admin');
        User::factory()->create()->each(function ($user) {
        $user->profile()->create([
            'full_name' => 'Admin',
            'bio' => 'This is a test bio.',
         ]);
        });
        
        // for($i = 0 ; $i < 11 ; $i++ ){
        //     $n = $i + 1;
        //     User::create([
        //         'name' => "`User$n`",
        //         'email' => "`test$n@example.com`",
        //         'password' => bcrypt('password'),
        //         ])->assignRole('user');
        // }
            // User::factory(10)->create()->assignRole('user');
        }

    }