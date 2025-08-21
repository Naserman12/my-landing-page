<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutMe extends Model
{
    use HasFactory;
    protected $table = 'about_me'; // لأنه مش plural بشكل افتراضي
    protected $fillable = [
        'full_name',
        'bio',
        'profile_image',
        'mission',
        'vision',
        'skills',
        'email',
        'phone',
    ];

    // نرجع skills كمصفوفة بدل نص
    protected $casts = [
        'skills' => 'array',
    ];
}
