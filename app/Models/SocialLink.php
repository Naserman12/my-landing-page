<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
     protected $fillable = ['platform', 'url'];
     // إرجاع أيقونة تلقائية حسب المنصة
    public function getIconAttribute(){
        $icons = [
            'facebook' => 'fa fa-facebook',
            'twitter' => 'fa fa-twitter',
            'instagram' => 'fa fa-instagram',
            'youtube' => 'fa fa-youtube',
            'tiktok' => 'fa fa-tiktok',
            'linkedin' => 'fa fa-linkedin',
            'email' => 'fa fa-email',
        ];
        return $icons[strtolower($this->platform)] ?? 'fa fa-link';
    }
}
