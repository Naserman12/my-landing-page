<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    //
     protected $fillable = ['original_url', 'short_code', 'clicks'];

     
     public function videos()
     {
         return $this->hasMany(Video::class);
        }
        protected $appends = ['full_short_url'];
        public function getFullShortUrlAttribute()
        {
            return url('/s/' . $this->short_code);
        }
    }
