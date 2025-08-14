<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
     protected $fillable = ['title', 'url', 'short_link_id'];

    public function shortLink()
    {
        return $this->belongsTo(ShortLink::class);
    }
}
