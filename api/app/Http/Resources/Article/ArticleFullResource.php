<?php

namespace App\Http\Resources\Article;
use App\Helpers\DateHelper;
use Carbon\Carbon;

use App\Http\Resources\DoctorResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleFullResource extends JsonResource
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
            'content' => html_entity_decode($this->content, ENT_QUOTES, 'UTF-8'),
            'is_published' => $this->is_published ? 1 : 0,
            'is_save' => $this->saved_by_users_count > 0 ? 1 : 0,
            'view' => $this->view,
            'type' => intval($this->type),
            'local_updated_at' => DateHelper::translateDateToKhmer($this->updated_at),
            'updated_at ' => Carbon::parse($this->created_at)->format('d F Y, h:i A'),
            'category' => $this->category ? new CategoryResource($this->category) : null,
            'tags' => TagResource::collection($this->tags),
            'doctor' => $this->users ? new DoctorResource($this->users) : null,
            // 'specialist' => $this->users->doctorProfile->specialist
            //     ? [
            //         'name' => $this->users->doctorProfile->specialist->name,
            //         'local_name' => $this->users->doctorProfile->specialist->local_name,
            //     ]
            //     : null,

        ];
    }
}
