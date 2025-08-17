<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Support\Str;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
     // عرض الإنجازات للجميع
    public function index()
    {
        return Achievement::latest()->get();
    }
     // إضافة إنجاز (مدير فقط)
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('achievements', 'public');
         }
         // حفظ الإنجاز
        $achievement = Achievement::create($data);
        // إنشاء رابط قصير تلقائي
        do {
            $shortCode = Str::random(6);
        } while (ShortLink::where('short_code', $shortCode)->exists());
        $shortLink = ShortLink::create([
            'short_code' => $shortCode,
            'original_url' => url('/achievement/' . $achievement->id),
            'clicks' => 0
        ]);

         $achievement->update(['short_code' => $shortCode]);
         return response()->json([
            'message' => 'تم إضافة الإنجاز',
            'data' => $achievement,
            'short_url' => url('/s/' . $shortCode),
            'short_link' => $shortLink
        ]);   
    }
    public function show(string $id) {
        // البحث أولًا عن الإنجاز حسب short_code، إذا ما وجد جرب حسب الـ ID
    $achievement = Achievement::where('short_code', $id)
                    ->orWhere('id', $id)
                    ->firstOrFail();
    return response()->json([
        'data' => $achievement,
        'clicks' => ShortLink::where('short_code', $achievement->short_code)->value('clicks'),
        'short_url' => url('/s/' . $achievement->short_code),
    ]);
    }
       // تعديل إنجاز (مدير فقط)
    public function update(Request $request, $id){
    $achievement = Achievement::findOrFail($id);
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
     if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($achievement->image) {
                Storage::disk('public')->delete($achievement->image);
            }
            $data['image'] = $request->file('image')->store('achievements', 'public');
        }
    $achievement->update($data);
    return response()->json([
        'message' => 'Achievement updated successfully',
        'data' => $achievement,
        'short_url' => url('/s/' . $achievement->short_code)
    ]);
}
        // احصائيات
    public function achievementStats($id){
        $achievement = Achievement::findOrFail($id);
        $shortLink = ShortLink::where('short_code', $achievement->short_code)->first();

        return response()->json([
            'achievement'   => $achievement->title,
            'clicks'        => $shortLink?->clicks ?? 0,
            'short_url'     => $shortLink?->full_short_url
        ]);
    }
    // حذف إنجاز (مدير فقط)
    public function destroy($id){
        $achievement = Achievement::findOrFail($id);
    // حذف الرابط القصير المرتبط
    ShortLink::where('short_code', $achievement->short_code)->delete();
    if ($achievement->image) {
    Storage::disk('public')->delete($achievement->image);
    }
    $achievement->delete();
    return response()->json([
        'message' => 'تم حذف الإنجاز'
      ]);
    }
}
