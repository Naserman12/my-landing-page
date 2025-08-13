<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
{
    $user = $request->user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $profile = $user->profile;

    if (!$profile) {
        return response()->json(['message' => 'Profile not found'], 404);
    }

    return response()->json($user->profile, 200);
}
    

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'string|max:255',
            'bio' => 'string',
            'avatar' => 'string|url',  // افتراضًا رابط، يمكن إضافة upload لاحقًا
        ]);

        $profile = $request->user()->profile;
        $profile->update($request->all());

        return response()->json($profile);
    }
}