<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
{
    public function index()
    {
        return SiteInfo::all();
    }

        public function store(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }
        

        $siteInfo = SiteInfo::first();
         if ($siteInfo) {
        // إذا موجود → تحديث
            $siteInfo->update($data);
        } else {
            // إذا ما في → إنشاء جديد
            SiteInfo::create($data);
        }

        return response()->json([
            'message' => 'Site info created successfully',
            'data' => $siteInfo
        ]);
    }

    public function update(Request $request, $id)
    {
        $siteInfo = SiteInfo::findOrFail($id);
        $data = $request->validate([
        'site_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'logo' => 'nullable|image',
        'email' => 'nullable|email',
        'phone' => 'nullable|string',
        'facebook' => 'nullable|url',
        'twitter' => 'nullable|url',
        'instagram' => 'nullable|url',
    ]);
         if ($request->hasFile('logo')) {
        $data['logo'] = $request->file('logo')->store('logos', 'public');
         }
        $siteInfo->update($data);
        return $siteInfo;
    }

    public function destroy(SiteInfo $siteInfo)
    {
        $siteInfo->delete();
        return response()->noContent();
    }
}
