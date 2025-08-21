<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialLink;

class SocialLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            [
                'platform' => 'facebook',
                'url' => 'https://facebook.com/example',
            ],
            [
                'platform' => 'twitter',
                'url' => 'https://twitter.com/example',
            ],
            [
                'platform' => 'instagram',
                'url' => 'https://instagram.com/example',
            ],
            [
                'platform' => 'youtube',
                'url' => 'https://youtube.com/example',
            ],
        ];
        foreach ($links as $link) {
            SocialLink::create($link);
        }
    }
}
