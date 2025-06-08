<?php

namespace App\Http\Controllers;

use App\Models\SaveArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DateHelper;

class SaveArticleController extends Controller
{
    public function index()
    {
        $savedArticles = SaveArticle::with([
            'article:id,title,short_description,thumbnail,category_id,updated_at,view',
            'article.category:id,name,local_name', // Load category directly
            'user:id,fullname,local_fullname,avatar'
        ])
            ->where('user_id', Auth::id())
            ->get();

        if ($savedArticles->isEmpty()) {
            return response()->json([
                'result' => true,
                'message' => 'No saved articles found',
                'data' => [],
            ]);
        }

        $user = $savedArticles->first()->user;

        return response()->json([
            'result' => true,
            'message' => 'Get successful',
            'user' => [
                'id' => $user->id,
                'fullname' => $user->fullname,
                'local_fullname' => $user->local_fullname,
                'avatar' => asset(
                    $user->avatar && $user->avatar !== 'user/no_avatar.jpg'
                    ? 'storage/' . $user->avatar
                    : 'storage/user/no_avatar.jpg'
                ),
            ],
            'articles' => $savedArticles->map(function ($savedArticle) {
                $article = $savedArticle->article;
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'short_description' => $article->short_description,
                    'local_updated_at' => DateHelper::translateDateToKhmer($article->updated_at),
                    'view' => $article->view,
                    'thumbnail' => $article->thumbnail
                        ? asset('storage/' . $article->thumbnail)
                        : null,
                    'category' => [
                        'name' => $article->category->name,
                        'local_name' => $article->category->local_name,
                    ],
                ];
            }),
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => ['required', 'exists:articles,id'],
        ]);

        $userId = Auth::id();

        if (SaveArticle::where('user_id', $userId)->where('article_id', $validated['article_id'])->exists()) {
            return response()->json(['message' => 'Article already saved'], 409);
        }

        $saveArticle = SaveArticle::create([
            'user_id' => $userId,
            'article_id' => $validated['article_id'],
        ]);

        return response()->json([
            'message' => 'Article saved successfully',
            'data' => $saveArticle
        ], 201);
    }
    public function destroy(Request $request, $id)
    {
        $request->merge(['article_id' => $id]);
        $request->validate([
            'article_id' => ['required', 'exists:articles,id'],
        ]);
        $saveArticle = SaveArticle::where('article_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$saveArticle) {
            return response()->json(['message' => 'Article not found or unauthorized'], 403);
        }

        $saveArticle->delete();

        return response()->json(['message' => 'Article unsaved successfully'], 200);
    }

}
