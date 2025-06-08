<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:categories,name'],
            'local_name' => ['required', 'string', 'unique:categories,local_name'],
            'content_type' => ['required', 'integer', 'min:1', 'max:2']
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->local_name = $request->local_name;
        $category->content_type = $request->content_type;

        $category->save();

        return response()->json([
            'results' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }

    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'min:1', 'max:255'],
            'content_type' => ['required', 'integer', 'min:1', 'max:2']
        ]);

        $category = new Category();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $category = $category->where('name', 'like', "%$search%")
                ->orWhere('local_name', 'like', "%$search%");
        }

        if ($request->filled('content_type')) {
            $contentType = $request->input('content_type');
            $category = $category->where('content_type', $contentType);
        }

        $categories = $category->limit(255)->get(['id', 'name', 'local_name']);

        return response()->json([
            'results' => true,
            'massage' => 'Get Categories successfully',
            'data' => $categories
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => ['required', 'integer', 'min:1', 'exists:categories,id'],
            'name' => ['required', 'string', 'unique:categories,name,' . $id],
            'local_name' => ['required', 'string', 'unique:categories,local_name,' . $id],
        ]);

        $category = new Category();
        $category->where('id', $id)->update($request->only(['name', 'local_name']));

        return response()->json([
            'results' => true,
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }
    public function destroy(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => ['required', 'integer', 'min:1', 'max:255', 'exists:categories,id']
        ]);

        $category = new Category();
        $category->where('id', $id)->delete();
        $category->delete();


        return response()->json([
            'results' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
