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
         return response()->json(Video::all());
    }
    public function store(Request $request){
       $data = $request->validate([
        'title' => 'required|string',
        'url' => 'required|url|max:255',
    ]);
    // إنشاء رابط قصير للفيديو
    do {
    $shortCode = Str::random(6);
    }while (ShortLink::where('short_code', $shortCode)->exists());
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
    public function show(string $id)
    {
         $video = Video::where('short_link_id', $id)
                      ->orWhere('id', $id)
                      ->firstOrFail();

        return response()->json([
            'status'  => 'success',
            'data' => $video,
            'short_url' => $video->shortLink?->full_short_url,
        ],200);
    }
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);
         // جلب الرابط القديم (إن وجد) قبل الحذف
        $oldLink =  $video->shortLink()->first();
        // الحفااظ على عدد النفرات
        $clicks = $oldLink ? $oldLink->clicks : 0;
        // حذف الرابط القديم
         $video->shortLink()->delete();
            // إنشاء رابط قصير للفيديو
        do {
        $shortCode = Str::random(6);
        } while (ShortLink::where('short_code', $shortCode)->exists());
        $shortLink = ShortLink::create([
            'original_url' => $data['url'],
            'short_code' => $shortCode,
            'clicks' => $clicks
        ]);
        $video->update([
            'title' => $data['title'],
            'url' => $data['url'],
            'short_link_id' => $shortLink->id,
        ]);
        return response()->json([
            'status'  => 'success',
            'message' => 'تم تحديث الفيديو',
            'data' => $video,
            'short_link' => $shortLink,
            'oldLink' => $oldLink,
        ],200);
    }
   public function destroy($id)
    {
        $video = Video::findOrFail($id);
         if(!$video){
            return response()->json([
                'status' => 'Error',
                'not found achievement',
            ],404);
         }
        ShortLink::where('id', $video->short_link_id)->delete();
        $video->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'تم حذف الفيديو'
        ],204);
    }
}
