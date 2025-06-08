<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactFullResource;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string'],
            'status' => ['in:qa,feedback']
        ]);
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        $validated['user_id'] = $user->id;

        $contact = Contact::create($validated);

        return response()->json([
            'result' => true,
            'message' => 'Contact message sent successfully!',
            'data' => $contact
        ], 201);
    }
    public function find(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($user->role_id != 1) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: You do not have access to this resource.'
            ], 403);
        }
        $request->merge(['id' => $id]);
        $request->validate(['id' => ['required', 'integer', 'min:0', 'exists:contacts,id']]);

        $contact = (new Contact())->where('id', $id)->first();

        return $this->res_success('get successfully', new ContactFullResource($contact));
    }
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'search' => ['nullable', 'string', 'min:1', 'max:250'],
        ]);
        $per_page = $request->filled('per_page') ? $request->input('per_page') : 20;
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($user->role_id != 1) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: You do not have access to this resource.'
            ], 403);
        }

        $query = Contact::query()->with('user')->orderBy('created_at', 'asc');
        // if ($request->has('status')) {
        //     $query->where('status', $request->status);
        // }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('fname', 'like', "%{$search}%")
                ->orWhere('lname', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $contacts = $query->latest()->paginate($per_page);

        return $this->res_paginate('Get Contact Successfully', ContactResource::collection($contacts), $contacts);
    }
    public function destroy($id)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
            if ($user->role_id != 1) {
                return response()->json([
                    'result' => false,
                    'message' => 'Permission denied: You cannot delete this.'
                ], 403);
            }
            $contact = Contact::findOrFail($id);
            $contact->delete();

            return response()->json([
                'result' => true,
                'message' => 'Contact deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete contact'
            ], 500);
        }
    }
    public function massDestroy(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
            if ($user->role_id != 1) {
                return response()->json([
                    'result' => false,
                    'message' => 'Permission denied: You cannot delete contacts.'
                ], 403);
            }

            $contact_ids = json_decode($request->input('contact_ids'), true);
            $request->merge(['contact_ids' => $contact_ids]);
            $request->validate([
                'contact_ids' => 'required|array',
                'contact_ids.*' => 'integer|exists:contacts,id'
            ]);

            Contact::whereIn('id', $request->contact_ids)->delete();

            return response()->json([
                'result' => true,
                'message' => 'Contacts deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete contacts'
            ], 500);
        }
    }
}
