<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\ShortLink;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
         return Video::with('shortLink')->latest()->get();
    }
    public function store(Request $request){
       $data = $request->validate([
        'title' => 'required|string',
        'url' => 'required|url|max:255',
    ]);
    // إنشاء رابط قصير للفيديو
    do {
    $shortCode = Str::random(6);
} while (ShortLink::where('short_code', $shortCode)->exists());
    $shortLink = ShortLink::create([
        'original_url' => $data['url'],
        'short_code' => $shortCode,
        'clicks' => 0
    ]);
    $video = Video::create([
        'title' => $data['title'],
        'url' => $data['url'],
        'short_link_id' => $shortLink->id,
    ]);
      return response()->json([
        'status'  => 'success',
        'message' => 'تم إضافة الفيديو والرابط المختصر تلقائيًا',
        'video' => $video,
        'short_link' => $shortLink
    ], 201);
} 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $video = Video::where('short_link_id', $id)
                      ->orWhere('id', $id)
                      ->firstOrFail();

        return response()->json([
            'status'  => 'success',
            'data' => $video,
            'short_url' => $video->shortLink?->full_short_url,
        ]);
    }
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);
        $video->update($data);
        return response()->json([
            'status'  => 'success',
            'message' => 'تم تحديث الفيديو',
            'data' => $video
        ]);
    }
   public function destroy($id)
    {
        $video = Video::findOrFail($id);
        ShortLink::where('id', $video->short_link_id)->delete();
        $video->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'تم حذف الفيديو'
        ]);
    }
}
