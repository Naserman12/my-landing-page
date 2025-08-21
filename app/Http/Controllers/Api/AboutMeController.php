<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;
use Illuminate\Http\Request;

class AboutMeController extends Controller
{
    // GET /api/about-me
    public function index()
    {
        $about = AboutMe::first(); // لأنه سجل واحد فقط
        return response()->json($about);
    }
    // PUT /api/about-me
    public function update(Request $request)
    {
        $rules = [
    'full_name'     => 'sometimes|required|string|max:255',
    'bio'           => 'sometimes|required|string',
    'profile_image' => 'nullable|string', // أو image لو فيه رفع صور
    'mission'       => 'nullable|string',
    'vision'        => 'nullable|string',
    'skills'        => 'nullable|string',
    'email'         => 'nullable|email',
    'phone'         => 'nullable|string',
    ];
    $about = AboutMe::first();  
    if (!$about) {
        // لو ما فيه سجل، نجعل full_name و bio إلزاميين
        $rules['full_name'] = 'required|string|max:255';
        $rules['bio'] = 'required|string';
    }
       $data = $request->validate($rules);
    if ($about) {
           $about->update($data);
           $message = 'تم تحديث البيانات بنجاح';
    }else {
        $about = AboutMe::create($data);
        $message = 'تم إنشاء البيانات بنجاح';
    }
        return response()->json(['data'=>$about, 'message' => $message]);
    }
}
