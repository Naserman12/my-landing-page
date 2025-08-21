<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if (!$user) {
            return response()->json(['Error' => 'لم يتم تنفيذ طلبك الرجاء التأكد من البيانات المدخلة']);
        }
        $user->assignRole('user'); // تعيين دور مستخدم عادي
        $user->profile()->create([
            'full_name' => $request->name,
            'bio' => 'bio',
            'avatar' => 'url',
        ]);
        $token = $user->createToken('register-token')->plainTextToken;
        return response()->json([
         'user' => $user,
         'roles' => $user->getRoleNames(),
         'token' => $token,
         'message' => 'تم تسجيل المستخدم بنجاح!',
        ], 201);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['البيانات المدخلة غير صحيحة.'],
            ]);
        }
        $user->tokens()->delete();
        $token = $user->createToken('login-token')->plainTextToken;
        return response()->json(['status'  => 'success', 'user data' => $user, 'token' => $token], 200);
    }
    public function logout(Request $request){
    // الحصول على access token مباشرة بدون تحميل user كامل
    $accessToken = $request->bearerToken();
    if (!$accessToken) {
        return response()->json(['message' => 'لم يتم الحصول التوكن '], 401);
    }
    // ابحث عن التوكن في قاعدة البيانات
    $token = \Laravel\Sanctum\PersonalAccessToken::findToken($accessToken);
    if (!$token) {
        return response()->json(['message' => 'التوكن غير صحيح'], 401);
    }
    // احذف التوكن
    $token->delete();
    return response()->json(['status'  => 'success', 'message' => 'تم تسجيل الخروج'], 200);
}

}