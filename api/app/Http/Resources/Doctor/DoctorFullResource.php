<?php

namespace App\Http\Resources\Doctor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\DateHelper;

class DoctorFullResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'user' => [
                'fullname' => $this->user?->fullname ?? null,
                'local_fullname' => $this->user?->local_fullname ?? null,
                'email' => $this->user?->email ?? null,
                'phone' => $this->user?->phone_number ?? null,
                'gender' => $this->user?->gender ?? null,
                'is_author' => boolval($this->is_author) ?? null,
                'is_verify' => boolval($this->is_verify) ?? null,
                'bio' => $this->biography ?? null,
                'avatar' => $this->user ? asset('storage/' . ($this->user->avatar ?? 'user/no_avatar.jpg')) : asset('storage/user/no_avatar.jpg'),
                'languages' => json_decode($this->spoken_languages ?? '[]', true),
            ],
            'specialist' => [
                'id' => $this->specialist?->id ?? null,
                'name' => $this->specialist?->name ?? null,
                'local_name' => $this->specialist?->local_name ?? null,
            ],
            'department' => [
                'id' => $this->department?->id ?? null,
                'name' => $this->department?->name ?? null,
                'local_name' => $this->department?->local_name ?? null,
            ],
            'center' => [
                'id' => $this->center?->id ?? null,
                'name' => $this->center?->name ?? null,
                'local_name' => $this->center?->local_name ?? null,
            ],
            'educations' => $this->user && $this->user->doctorEducations
                ? $this->user->doctorEducations->map(function ($education) {
                    return [
                        'institution' => $education->institution_name ?? null,
                        'location' => $education->location ?? null,
                        'degree' => $education->degree_name ?? null,
                        'start' => DateHelper::translateDateToKhmer($education->start_date) ?? null,
                        'end' => DateHelper::translateDateToKhmer($education->end_date) ?? null,
                    ];
                })->all()
                : [],
            // Uncomment and fix experiences if needed
            'experiences' => $this->user && $this->user->doctorExperiences
                ? $this->user->doctorExperiences->map(function ($experience) {
                    return [
                        'location' => $experience->location ?? null,
                        'organization_name' => $experience->organization_name ?? null,
                        'responsibilities' => $experience->responsibilities ?? null,
                        'position' => $experience->position ?? null,
                        'start_date' => DateHelper::translateDateToKhmer($experience->start_date) ?? null,
                        'end_date' => DateHelper::translateDateToKhmer($experience->end_date) ?? null,
                    ];
                })->all()
                : [],
            // $table->unsignedTinyInteger('specialist_id');
            // $table->string('organization_name');
            // $table->string('position');
            // $table->text('responsibilities');
            // $table->date('start_date');
            // $table->date('end_date')->nullable();
            // $table->boolean('is_current')->default(false);
            // $table->string('location');
            // $table->boolean('is_verified')->default(true);
        ];
    }
}
