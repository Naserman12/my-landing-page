<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutMeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
            DB::table('about_me')->insert([
            'full_name'     => 'ناصر فلاته',
            'bio'           => 'مطور ويب شغوف ببناء تطبيقات مبتكرة.',
            'profile_image' => '/',
            'mission'       => 'مساعدة الشركات على التحول الرقمي بكفاءة.',
            'vision'        => 'أن أكون من أبرز المطورين في المنطقة العربية.',
            'skills'        => json_encode(['PHP', 'Laravel', 'JavaScript', 'Vue.js']),
            'email'         => 'nasser@example.com',
            'phone'         => '+966500000000',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

    }
}
