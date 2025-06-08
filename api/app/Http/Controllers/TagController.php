<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:tags,name'],
            'local_name' => ['required', 'string', 'unique:tags,local_name'],
            'content_type' => ['required', 'integer', 'min:1', 'max:2']

        ]);

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->local_name = $request->local_name;
        $tag->content_type = $request->content_type;

        $tag->save();

        return response()->json([
            'results' => true,
            'message' => 'Tag created successfully',
            'data' => $tag
        ]);
    }

    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'min:1', 'max:255'],
            'content_type' => ['required', 'integer', 'min:1', 'max:2']
        ]);

        $search = $request->input('search');
        $tag = new Tag();

        if ($request->filled('search')) {
            $tag = $tag->where('name', 'like', "%$search%")
                ->orWhere('local_name', 'like', "%$search%");
        }

        if ($request->filled('content_type')) {
            $contentType = $request->input('content_type');
            $tag = $tag->where('content_type', $contentType);
        }

        $tags = $tag->limit(255)->get(['id', 'name', 'local_name']);

        return response()->json([
            'results' => true,
            'message' => 'Get Tags successfully',
            'data' => $tags
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => ['required', 'integer', 'min:1', 'exists:tags,id'],
            'name' => ['required', 'string', 'unique:tags,name,' . $id],
            'local_name' => ['required', 'string', 'unique:tags,local_name,' . $id]
        ]);

        $tag = new Tag();
        $tag->where('id', $id)->update($request->only(['name', 'local_name']));

        return response()->json([
            'results' => true,
            'message' => 'Tag updated successfully',
            'data' => $tag
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => ['required', 'integer', 'min:1', 'exists:tags,id']
        ]);

        $tag = new Tag();
        $tag->where('id', $id)->delete();
        $tag->delete();

        return response()->json([
            'results' => true,
            'message' => 'Tag deleted successfully',
        ]);
    }
}
