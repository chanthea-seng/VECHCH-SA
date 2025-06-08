<?php

namespace App\Http\Controllers\Article;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ArticleImage;
use Illuminate\Support\Facades\Storage;

class ArticleImageController extends Controller
{
    public function store($article_id, $image_path)
    {
        return ArticleImage::create([
            'article_id' => $article_id,
            'image_path' => $image_path,
        ]);
        // $req->validate([
        //     'article_id' => ['required', 'integer', 'min:1',],
        //     'image_path' => ['required', 'string', 'max:250'],
        // ]);

        // $image = new ArticleImage();
        // $image->article_id = $req->input('article_id');
        // $image->image_path = $req->input('image_path');
        // $image->save();
    }
    public function uploadImage(Request $req, $id)
    {
        $req->merge(['article_id' => $id]);
        $req->validate([
            'article_id' => ['required', 'integer', 'min:1'],
            'image' => ['required', 'file', 'mimetypes:image/jpeg,image/png', 'max:1024']
        ]);

        $imageCount = ArticleImage::where('article_id', $id)->count();
        if ($imageCount >= 6) {
            return response()->json(['error' => 'You can only upload up to 4 images.'], 400);
        }

        if ($req->hasFile('image')) {
            $imagePath = $req->file('image')->store('article', ['disk' => 'public']);
            $image = new ArticleImage();
            $image->article_id = $req->input('article_id');
            $image->image_path = $imagePath;
            $image->save();

            return response()->json(['url' => asset("storage/" . $imagePath)]);
        }

        return response()->json(['error' => 'Image upload failed'], 500);
    }

    public function deleteImage(Request $req, $id)
    {
        $req->merge(['article_id' => $id]);
        $url = $req->input('url');

        // Validate URL
        $req->validate([
            'article_id' => ['required', 'integer', 'min:1'],
            'url' => ['required', 'regex:/^http:\/\/[a-zA-Z0-9.-]+(:\d+)?\/[^\s]+$/'],
        ]);

        $path = parse_url($url, PHP_URL_PATH);
        $filePath = str_replace('/storage/', '', $path);

        // Find the image record in the database
        $image = ArticleImage::where('article_id', $id)
            ->where('image_path', $filePath)
            ->first();

        if ($image) {
            // Delete the file from storage
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            // Remove the database record
            $image->delete();

            return response()->json(['message' => 'Image deleted successfully.'], 200);
        }

        return response()->json(['error' => 'Image not found.'], 404);
    }


    public function destroy($articleId)
    {
        $images = ArticleImage::where('article_id', $articleId)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }


}
