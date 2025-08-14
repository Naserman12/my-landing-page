<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          // عرض الرسائل (للمدير فقط)
         return response()->json(Contact::latest()->paginate(10));
    }
      /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        if ($data->fails()) {
         return response()->json([
             'status' => 'error',
             'errors' => $data->errors()
         ], 422);
        }
        $contact = Contact::create($data->validate());
        return response()->json([
            'status'  => 'success',
            'message' => 'تم إرسال رسالتك بنجاح',
            'data' => $contact
        ], 201);
    }
    /**
     * Remove the specified resource from storage.
     */
    // حذف رسالة
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(['message' => 'تم حذف الرسالة بنجاح']);
    }
}
