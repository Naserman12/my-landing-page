<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index() {
        return response()->json(Service::all());

    }
    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);


        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('services', 'public');
        }
        $service = Service::create($data);

        return response()->json([
            'message' => ' ✅ تمت إضافة الخدمة بنجاح',
            'data' => $service
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);
         if ($request->hasFile('icon')) {
            // حذف الأيقونة القديمة إن وجدت
            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }
            $data['icon'] = $request->file('icon')->store('services', 'public');
        }
        $service->update($data);
        return response()->json([
            'message' => ' ♻️ تم تحديث الخدمة بنجاح',
            'data' => $service
        ]);
    }
    public function destroy($id) {
         $service = Service::findOrFail($id);
         if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }
         $service->delete();
         return response()->json(['message' => 'تم حذف الخدمة بنجاح']);
    }
}
