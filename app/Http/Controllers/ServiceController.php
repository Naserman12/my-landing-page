<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index() {
        return response()->json(Service::all());

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $service = Service::create($data);

        return response()->json([
            'message' => 'تمت إضافة الخدمة بنجاح',
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
        $service->update($data);
        return response()->json([
            'message' => 'تم تحديث الخدمة بنجاح',
            'data' => $service
        ]);
    }
    public function destroy($id)
    {
         $service = Service::findOrFail($id);
         $service->delete();
         return response()->json(['message' => 'تم حذف الخدمة بنجاح']);
    }
}
