<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleCardResource;
use App\Http\Resources\Article\ArticleFullResource;
use App\Models\Article;
use App\Models\DoctorProfile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    use HasFactory;

    public function index(Request $req)
    {
        $req->validate([
            'type' => ['nullable', 'integer', 'min:1', 'max:2'],
            'published' => ['nullable', 'integer', 'min:1', 'max:1'],
            'alphabet' => ['nullable', 'string', 'min:1', 'max:1'],
            'category_id' => ['nullable', 'integer', 'min:1', 'max:50', 'exists:categories,id'],
            'search' => ['nullable', 'string', 'min:1', 'max:250'],
            'scol' => ['nullable', 'string', 'min:0', 'in:published_at,id,title'],
            'sdir' => ['nullable', 'string', 'in:desc,asc'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $scol = $req->filled('scol') ? $req->input('scol') : 'id';
        $sdir = $req->filled('sdir') ? $req->input('sdir') : 'desc';
        $per_page = $req->filled('per_page') ? $req->input('per_page') : 50;

        $article = new Article();

        if ($req->filled('search')) {
            $search = $req->input('search');
            $article = $article->where(function ($x) use ($search) {
                $x->whereHas('category', function ($y) use ($search) {
                    $y->where('name', 'like', "%" . $search . "%")
                        ->orWhere('local_name', 'like', "%" . $search . "%");
                })
                    ->orWhereHas('tags', function ($y) use ($search) {
                        $y->where('name', 'like', "%" . $search . "%")
                            ->orWhere('local_name', 'like', "%" . $search . "%");
                    })
                    ->orWhere('title', 'like', "%" . $search . "%")
                    ->orWhere('short_description', 'like', "%" . $search . "%");
            });
        }

        if ($req->filled('alphabet')) {
            $article = $article->where('title', 'like', $req->input('alphabet') . "%");
        }

        if ($req->filled('category_id')) {
            $article = $article->where('category_id', $req->input('category_id'));
        }

        if ($req->filled('type')) {
            $article = $article->where('type', $req->input('type'));
        }
        $article = $article->where('is_published', true)->withCount('savedByUsers')
            ->with(['category:id,name,local_name', 'tags:id,name,local_name', 'users'])
            ->orderBy($scol, $sdir);

        $articles = $article->paginate($per_page);

        return $this->res_paginate('get successfully', ArticleCardResource::collection($articles), $articles);
    }

    public function getAuthor(Request $req)
    {
        // Ensure the user is authenticated
        $user = Auth::user();
        if (!$user || $user->role_id != 2) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate request parameters
        $req->validate([
            'type' => ['nullable', 'integer', 'min:1', 'max:2'],
            'published' => ['nullable', 'integer', 'min:0', 'max:1'],
            'alphabet' => ['nullable', 'string', 'min:1', 'max:1'],
            'category_id' => ['nullable', 'integer', 'min:1', 'max:50', 'exists:categories,id'],
            'search' => ['nullable', 'string', 'min:1', 'max:250'],
            'scol' => ['nullable', 'string', 'in:published_at,id,title'],
            'sdir' => ['nullable', 'string', 'in:desc,asc'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $sdir = $req->filled('sdir') ? $req->input('sdir') : 'desc';
        $scol = $req->filled('scol') ? $req->input('scol') : 'id';
        $per_page = $req->input('per_page', 50);

        // Start building query
        $article = Article::where('doctor_id', $user->id);

        if ($req->filled('search')) {
            $search = $req->input('search');
            $article = $article->where(function ($x) use ($search) {
                $x->whereHas('category', function ($y) use ($search) {
                    $y->where('name', 'like', "%" . $search . "%")
                        ->orWhere('local_name', 'like', "%" . $search . "%");
                })
                    ->orWhereHas('tags', function ($y) use ($search) {
                        $y->where('name', 'like', "%" . $search . "%")
                            ->orWhere('local_name', 'like', "%" . $search . "%");
                    })
                    ->orWhere('title', 'like', "%" . $search . "%")
                    ->orWhere('short_description', 'like', "%" . $search . "%");
            });
        }

        // if ($req->filled('alphabet')) {
        //     $article = $article->where('title', 'like', "{$req->input('alphabet')}%");
        // }

        if ($req->filled('category_id')) {
            $article = $article->where('category_id', $req->input('category_id'));
        }

        if ($req->filled('type')) {
            $article = $article->where('type', $req->input('type'));
        }
        if ($req->filled('published')) {
            $article = $article->where('is_published', $req->input('published'));
        }
        $articles = $article
            ->with(['category:id,name,local_name', 'tags:id,name,local_name'])
            ->orderBy($scol, $sdir)
            ->paginate($per_page);

        return $this->res_paginate('Fetched successfully', ArticleCardResource::collection($articles), $articles);
    }

    public function checkAuthor(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($user->role_id != 2) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: not doctor.'
            ], 403);
        }
        $author = DoctorProfile::where('user_id', $user->id)->first();

        if (!$author || $author->is_author != 1) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: You are not authorized to write articles.'
            ], 200);
        }

        return response()->json([
            'result' => true,
            'message' => 'Authorized to write articles.'
        ], 200);
    }
    public function incrementViewCount($id)
    {
        $article = Article::findOrFail($id);
        $article->increment('view');

        return response()->json([
            'message' => 'View count updated successfully.',
            'view' => $article->view
        ]);
    }
    public function find($id)
    {
        $article = Article::withCount('savedByUsers')->with(['category:id,name,local_name', 'tags:id,name,local_name', 'users:id,fullname,local_fullname,avatar'])
            ->find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return $this->res_success('get success', new ArticleFullResource($article));
    }
    public function store(Request $req)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        $doctorId = $user->id;
        // ?: is null
        $tag_ids = json_decode($req->input('tag_ids')) ?: [];
        $req->merge(['tag_ids' => $tag_ids]);

        $req->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png', 'max:1024'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'is_published' => ['boolean'],
            'type' => ['required', 'integer', 'min:1', 'max:2'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'min:1', 'exists:tags,id']
        ]);
        $article = new Article();
        // Assign values
        $article->doctor_id = $doctorId;
        $article->category_id = $req->input('category_id') ?? null;
        $article->title = $req->input('title') ?? null;
        $article->short_description = $req->input('short_description') ?? null;
        $article->content = htmlentities($req->input('content'), ENT_QUOTES, 'UTF-8') ?? null;
        $article->is_published = $req->input('is_published') ?? false;
        $article->type = $req->input('type');
        $article->save();

        $thumbnail = 'article/no_thumbnail.jpg';
        if ($req->hasFile('thumbnail')) {
            $thumbnail = $req->file('thumbnail')->store('article', ['disk' => 'public']);
            (new ArticleImageController())->store($article->id, $thumbnail);
        }
        $article->thumbnail = $thumbnail;
        $article->save();

        $article->tags()->sync($tag_ids);

        return response()->json([
            'result' => true,
            'message' => 'Saved successfully',
            'data' => new ArticleCardResource($article)
        ]);
    }

    public function update(Request $req, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($user->role_id == 3) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: You cannot update this.'
            ], 403);
        }
        $doctorId = $user->id;

        $article = Article::findOrFail($id);
        // ?: is null
        $tag_ids = [];
        if ($req->filled('tag_ids')) {
            $tag_ids = array_map('intval', json_decode($req->input('tag_ids'), true));
        }
        $req->merge(['tag_ids' => $tag_ids, 'id' => $id]);
        $req->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png', 'max:1024'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'is_published' => ['boolean'],
            'type' => ['required', 'integer', 'min:1', 'max:2'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'min:1', 'exists:tags,id']
        ]);

        $article->doctor_id = $doctorId;
        $article->category_id = $req->input('category_id');
        $article->title = $req->input('title');
        $article->short_description = $req->input('short_description');
        $article->content = htmlentities($req->input('content'), ENT_QUOTES, 'UTF-8');
        $article->is_published = $req->input('is_published') ?? false;
        $article->type = $req->input('type');

        if ($req->hasFile('thumbnail')) {
            if ($article->thumbnail && $article->thumbnail !== 'article/no_thumbnail.jpg') {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $thumbnail = $req->file('thumbnail')->store('article', ['disk' => 'public']);
            (new ArticleImageController())->store($article->id, $thumbnail);
            $article->thumbnail = $thumbnail;
        }
        // if ($article->is_published == true) {
        //     $article->notifications()->create([
        //         'message' => 'New article created',
        //     ]);
        // }
        $article->save();
        $article->tags()->sync($tag_ids);

        return $this->res_success('Update Complete', new ArticleFullResource($article));
    }
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($user->role_id == 3) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: You cannot delete this.'
            ], 403);
        }
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        (new ArticleImageController)->destroy($article->id);
        $article->delete();
        return response()->json([
            'result' => true,
            'message' => 'Post and its images deleted successfully.',
        ]);
    }

    public function massDestroy(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($user->role_id == 3) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: You cannot delete these.'
            ], 403);
        }

        $article_ids = [];
        try {
            $article_ids = json_decode($request->input('article_ids'), true);
            $request->merge(['article_ids' => $article_ids]);
            $request->validate(
                [
                    'article_ids' => ['required', 'array'],
                    'article_ids.*' => ['integer', 'min:1', 'exists:articles,id']
                ]
            );
            if (is_array($article_ids)) {
                $article_ids = array_map('intval', $article_ids);
            }

            if (empty($article_ids)) {
                return response()->json([
                    'result' => false,
                    'message' => 'No valid article IDs provided.'
                ], 422);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }


        try {
            $articleImageController = new ArticleImageController;
            $articles = Article::whereIn('id', $article_ids)->get();
            foreach ($articles as $article) {
                $articleImageController->destroy($article->id);
                $article->delete();
            }
            return $this->res_success('Delete article success');
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error deleting articles: ' . $e->getMessage()
            ], 500);
        }
    }
    public function countArticle(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($user->role_id !== 2) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: Only doctor can use.'
            ], 403);
        }

        $articles = new Article();
        $counts = [
            'total_article' => $articles->where('doctor_id', $user->id)
                ->where('is_published', 1)
                ->count(),
            'total_views_article' => $articles->where('doctor_id', $user->id)
                ->sum('view'),
            'total_general_article' => $articles->where('type', 1)
                ->where('is_published', 1)
                ->where('doctor_id', $user->id)
                ->count(),
            'total_disease_article' => $articles->where('type', 2)
                ->where('doctor_id', $user->id)
                ->where('is_published', 1)
                ->count(),

            'total_unpublished' => $articles->where('is_published', 0)
                ->where('doctor_id', $user->id)
                ->count(),
        ];

        return response()->json([
            'result' => true,
            'message' => 'Counting Booking Type Service successfully',
            'data' => $counts,
            'user' => $user->id,
        ]);

    }
}
