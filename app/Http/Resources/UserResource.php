<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $baseData = [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'email' => $this->email,
            'role' => $this->role,
            'role_label' => $this->role_label,
            'bio' => $this->bio,
            'phone' => $this->phone,
            'location' => $this->location,
            'website' => $this->website,
            'profile_photo_url' => $this->profile_photo_url,
            'is_public' => $this->is_public,
            'is_available_for_contact' => $this->is_available_for_contact,
            'profile_completeness' => $this->getProfileCompleteness(),
            'joined_at' => Carbon::parse($this->created_at)->format('d.m.Y'),
        ];

        // Adaugă câmpuri specifice rolului
        switch ($this->role) {
            case 'student':
                $baseData['student_info'] = [
                    'school' => $this->school,
                    'year_of_study' => $this->year_of_study,
                    'skills' => $this->skills ?? [],
                    'has_cv' => !empty($this->cv_path),
                ];
                break;

            case 'teacher':
                $baseData['teacher_info'] = [
                    'department' => $this->department,
                    'title' => $this->title,
                    'specializations' => $this->specializations ?? [],
                ];
                break;

            case 'company':
                $baseData['company_info'] = [
                    'company_name' => $this->company_name,
                    'company_type' => $this->company_type,
                    'company_size' => $this->company_size,
                    'company_description' => $this->company_description,
                ];
                break;
        }

        return $baseData;
    }
}