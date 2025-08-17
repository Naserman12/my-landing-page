<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request){
    $user = $request->user();
    if (!$user) {
        return response()->json(['message' => 'ليس لديك صلاحية للوصل لهذه الصفحة'], 401);
    }
    $profile = $user->profile;
    if (!$profile) {
        return response()->json(['message' => 'لا يوجد ملف شخصي للمستخدم'], 404);   
    }
    return response()->json(['status'  => 'success', 'data' => $user->profile, 'message' => 'تم الحصول على الملف الشخصي'], 200);
}
public function update(Request $request){
    $request->validate([
        'full_name' => 'string|max:255',
        'bio' => 'string',
        'avatar' => 'string|url',  // افتراضًا رابط، يمكن إضافة upload لاحقًا
    ]);
    $profile = $request->user()->profile;
    if (!$profile) {
        return response()->json(['message' => 'حدث خطأ لم يتم التحديث'], 401);
        }
        $profile->update($request->only( 'full_name', 'bio', 'avatar'));
        return response()->json(['status'  => 'success', 'data'=>$profile, 'message' => 'تم تحديث الملف الشخصي']);
    }
}