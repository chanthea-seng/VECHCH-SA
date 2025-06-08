<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\DoctorResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\CategoryResource;
use Carbon\Carbon;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'thumbnail' => asset($this->thumbnail === 'article/no_thumbnail.jpg'
                ? 'storage/article/no_thumbnail.jpg'
                : "storage/" . $this->thumbnail),
            'short_description' => $this->short_description,
            'type' => intval($this->type),
            'view' => $this->view,
            'published_at' => $this->published_at,
            'is_published' => $this->is_published,
            'updated_at' => DateHelper::translateDateToKhmer($this->updated_at),
            'local_updated_at' => Carbon::parse($this->created_at)->format('d F Y'),
            'is_save' => $this->saved_by_users_count > 0 ? 1 : 0,
            'category' => $this->category ? new CategoryResource($this->category) : null,
            'tags' => TagResource::collection($this->tags),
            'doctor' => $this->users ? new DoctorResource($this->users) : null,
        ];
    }
}
