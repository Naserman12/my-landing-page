<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'original_url' => 'required|url',
        ]);
        // توليد كود فريد
        do {
            $shortCode = Str::random(6);
        } while (ShortLink::where('short_code', $shortCode)->exists());

        $shortLink = ShortLink::create([
            'original_url' => $data['original_url'],
            'short_code' => $shortCode,
        ]);

        return response()->json(['data' =>$shortLink], 201);
    }
    public function redirect($code)
    {
        $shortLink = ShortLink::where('short_code', $code)->firstOrFail();
        // زيادة عداد النقرات
        $shortLink->increment('clicks');
        return redirect()->away($shortLink->original_url);
    }
    public function stats($code)
    {
         $shortLink = ShortLink::where('short_code', $code)->firstOrFail();
        return response()->json([
            'original_url' => $shortLink->original_url,
            'clicks' => $shortLink->clicks,
            'full_short_url' => $shortLink->full_short_url
        ]);
    }
}
