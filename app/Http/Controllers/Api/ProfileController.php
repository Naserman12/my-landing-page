<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user()->profile);
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