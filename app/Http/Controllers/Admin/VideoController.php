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
    public function index()
    {
        //
         return Video::with('shortLink')->latest()->get();
    }
    public function store(Request $request)
    {
       $data = $request->validate([
        'title' => 'required|string',
        'url' => 'required|url',
    ]);
    // إنشاء رابط قصير للفيديو
    $shortLink = ShortLink::create([
        'title' => $data['title'],
        'original_url' => $data['url'],
        'short_code' => Str::random(6),
        'clicks' => 0
    ]);
    $video = Video::create([
        'title' => $data['title'],
        'url' => $data['url'],
        'short_link_id' => $shortLink->id,
    ]);
      return response()->json([
        'message' => 'تم إضافة الفيديو والرابط القصير تلقائيًا',
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
            'data' => $video,
            'short_url' => url('/s/' . $video->short_code)
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'url' => 'required|url',
        ]);
        $video->update($data);
        return response()->json([
            'message' => 'Video updated successfully',
            'data' => $video
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        $video = Video::findOrFail($id);

        ShortLink::where('short_code', $video->short_code)->delete();

        $video->delete();

        return response()->json([
            'message' => 'Video deleted successfully'
        ]);
    }
}
