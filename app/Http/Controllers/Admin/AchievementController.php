<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Support\Str;
use App\Models\ShortLink;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     // عرض الإنجازات للجميع
    public function index()
    {
        return Achievement::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
     // إضافة إنجاز (مدير فقط)
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('achievements', 'public');
         }
         // حفظ الإنجاز
        $achievement = Achievement::create($data);
        // إنشاء رابط قصير تلقائي
        $shortCode = Str::random(6);
        ShortLink::create([
            'short_code' => $shortCode,
            'original_url' => url('/achievement/' . $achievement->id),
        ]);
         $achievement->update(['short_code' => $shortCode]);
         return response()->json([
            'message' => 'Achievement created successfully',
            'data' => $achievement,
            'short_url' => url('/s/' . $shortCode)
        ]);
        
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // البحث أولًا عن الإنجاز حسب short_code، إذا ما وجد جرب حسب الـ ID
    $achievement = Achievement::where('short_code', $id)
                    ->orWhere('id', $id)
                    ->firstOrFail();

    return response()->json([
        'data' => $achievement,
        'short_url' => url('/s/' . $achievement->short_code)
    ]);
    }
    /**
     * Update the specified resource in storage.
     */
    // تعديل إنجاز (مدير فقط)
    public function update(Request $request, $id)
{
    $achievement = Achievement::findOrFail($id);

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image',
    ]);

    if ($request->hasFile('image')) {
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
    public function achievementStats($id)
    {
        $achievement = Achievement::findOrFail($id);

        $shortLink = ShortLink::where('code', $achievement->short_code)->first();

        return response()->json([
            'achievement' => $achievement->title,
            'clicks' => $shortLink ? $shortLink->clicks : 0,
            'short_url' => $shortLink ? url('/s/' . $shortLink->code) : null,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    // حذف إنجاز (مدير فقط)
    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);

    // حذف الرابط القصير المرتبط
    ShortLink::where('short_code', $achievement->short_code)->delete();

    $achievement->delete();

    return response()->json([
        'message' => 'Achievement deleted successfully'
      ]);
    }
}
