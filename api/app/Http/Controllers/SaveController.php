<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Save;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// class SaveController extends Controller
// {

//     public function store(Request $req)
//     {
//         $req->validate([
//             'saveable_id' => ['required', 'integer', 'min:1'],
//             'saveable_type' => ['required', 'string', 'in:doctor,article'],
//         ]);

//         $user = Auth::user();
//         if (!$user) {
//             return response()->json([
//                 'result' => false,
//                 'message' => 'Unauthorized'
//             ], 401);
//         }

//         $user_id = $user->id;

//         $modelMap = [
//             'article' => Article::class,
//             'doctor' => User::class, // Fixed typo from USer to User
//         ];

//         if (!isset($modelMap[$req->saveable_type])) {
//             return response()->json(['error' => 'Invalid saveable_type'], 422);
//         }

//         $modelClass = $modelMap[$req->saveable_type];

//         // Ensure the referenced object exists
//         if (!$modelClass::where('id', $req->saveable_id)->exists()) {
//             return response()->json(['error' => 'Invalid saveable_id'], 422);
//         }

//         // Avoid duplicate entries
//         $existingSave = Save::where([
//             'user_id' => $user_id,
//             'saveable_id' => $req->saveable_id,
//             'saveable_type' => $modelClass,
//         ])->first();

//         if ($existingSave) {
//             return response()->json([
//                 'message' => 'Already saved',
//                 'data' => $existingSave->load('saveable')
//             ], 200);
//         }

//         $save = Save::create([
//             'user_id' => $user_id,
//             'saveable_id' => $req->saveable_id,
//             'saveable_type' => $modelClass,
//         ]);

//         return response()->json([
//             'message' => 'Saved successfully',
//             'data' => $save->load('saveable')
//         ], 201);
//     }

//     public function index(Request $req)
//     {
//         $req->validate([
//             'type' => ['nullable', 'string', 'in:doctor,article']
//         ]);

//         $modelMap = [
//             'article' => Article::class,
//             'doctor' => User::class,
//         ];

//         $query = Save::with('saveable');

//         if ($req->filled('type')) {
//             $query->where('saveable_type', $modelMap[$req->type]);
//         }

//         return response()->json($query->get());
//     }


//     public function find($id)
//     {
//         $save = Save::with('saveable')->find($id);

//         if (!$save) {
//             return response()->json(['error' => 'Save not found'], 404);
//         }

//         return response()->json($save);
//     }

//     public function destroy($id)
//     {
//         $save = Save::find($id);

//         if (!$save) {
//             return response()->json(['error' => 'Save not found'], 404);
//         }

//         $save->delete();

//         return response()->json(['message' => 'Save removed successfully']);
//     }



// }
