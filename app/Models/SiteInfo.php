<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
   
    protected $fillable = [
        'site_name',
        'description',
        'logo',
        'email',
        'phone',
        'facebook',
        'twitter',
        'instagram',
    ];
}
