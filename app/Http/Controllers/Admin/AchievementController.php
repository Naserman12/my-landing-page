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
        return 
               response()->json([
                'status' => 'success',
                'All Achievements' =>Achievement::latest()->get(),
               ]);
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
         // إنشاء رابط قصير تلقائي
         do {
             $shortCode = Str::random(6);
            } while (ShortLink::where('short_code', $shortCode)->exists());
            $shortLink = ShortLink::create([
                'short_code' => $shortCode,
                'original_url' => url('api/s/'.$shortCode),
                'clicks' => 0
            ]);
         $achievement = Achievement::create($data);
         $achievement->update(['short_code' => $shortCode]);
         return response()->json([
            'message' => 'تم إضافة الإنجاز',
            'data' => $achievement,
            'short_url' => url('api/s/'. $shortCode),
            'short_link' => $shortLink
         ],201);   
    }
    public function show(string $code) {
        // البحث أولًا عن الإنجاز حسب short_code، إذا ما وجد جرب حسب الـ ID
    $achievement = Achievement::where('short_code', $code)->orWhere('id', $code)
    ->firstOrFail();
    $short_code = $achievement->short_code;
    $shortLink = ShortLink::where('short_code', $short_code)->firstOrFail();
    return response()->json([
        'data' => $achievement,
        'short_code' => $shortLink,
        // 'clicks' => $shortLink->clicks,
    ],200);
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
         // جلب الرابط القديم (إن وجد) قبل الحذف
        $oldLink = ShortLink::where('short_code', $achievement->short_code)->first();
        // الحفااظ على عدد النفرات
        $clicks = $oldLink ? $oldLink->clicks : 0;
         // حذف الرابط القصير القديم بدون علاقة
        ShortLink::where('short_code', $achievement->short_code)->delete();
         // إنشاء رابط قصير تلقائي
        do {
            $shortCode = Str::random(6);
        } while (ShortLink::where('short_code', $shortCode)->exists());
         $shortLink = ShortLink::create([
            'short_code' => $shortCode,
            'original_url' => $achievement->short_code,
            'clicks' => $clicks
        ]);
        $achievement->update(['short_code' => $shortCode]);
        $achievement->update($data);
    return response()->json([
        'message' => 'Achievement updated successfully',
        'data' => $achievement,
        'short_url' => url('api/s/'.$shortCode),
        'short_link' => $shortLink,
        'old_Short_Link' => $oldLink,
    ],200);
}
    // حذف إنجاز (مدير فقط)
    public function destroy($id){
        $achievement = Achievement::findOrFail($id);
        if(!$achievement){
            return response()->json([
                'status' => 'Error',
                'not found achievement',
            ],404);
        }
    // حذف الرابط القصير المرتبط
    ShortLink::where('short_code', $achievement->short_code)->delete();
    if ($achievement->image) {
    Storage::disk('public')->delete($achievement->image);
    }
    $achievement->delete();
    return response()->json([
        'message' => 'تم حذف الإنجاز'
      ],204);
    }
}
