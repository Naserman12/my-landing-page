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

        $shortCode = Str::random(6);

        return ShortLink::create([
            'original_url' => $data['original_url'],
            'short_code' => $shortCode,
        ]);
    }
    public function redirect($code)
    {
        $shortLink = ShortLink::where('short_code', $code)->firstOrFail();
        // زيادة عداد النقرات
        $shortLink->increment('clicks');
        return redirect()->away($shortLink->original_url);
    }

    public function show($shortCode)
    {
        $shortLink = ShortLink::where('short_code', $shortCode)->firstOrFail();
        $shortLink->increment('clicks');
        return redirect($shortLink->original_url);
    }
    public function index()
    {
        //
    }
    public function stats($code)
    {
    $shortLink = ShortLink::where('code', $code)->firstOrFail();

    return response()->json([
        'original_url' => $shortLink->original_url,
        'clicks' => $shortLink->clicks,
    ]);
    }


    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
