<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        return response()->json([SocialLink::all()],200);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'platform' => 'required|string|max:50',
            'url' => 'required|url',
        ]);
        $social = SocialLink::create($data);
        return response()->json($social, 201);
    }
    public function show($id) {
        $social = SocialLink::findOrFail($id);
        return response()->json([$social, 'Icon' => $social->icon]);
    }
    public function update(Request $request, $id){
        $data = $request->validate([
            'platform' => 'sometimes|string|max:50',
            'url' => 'sometimes|url',
        ]);
        $social = SocialLink::findOrFail($id);
        $social->update($data);
        return response()->json($social);
    }
    public function destroy($id){
        $social = SocialLink::findOrFail($id);
        $social->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'تم حذف حسابك'
        ], 204);
    }
}
