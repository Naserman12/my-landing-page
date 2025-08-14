<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
         $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        $contact = Contact::create($data);

        return response()->json([
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
