<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Anyone can view the courses list
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Course $course): bool
    {
        // Anyone can view published courses
        if ($course->isPublished()) {
            return true;
        }
        
        // Only the instructor can view their own draft courses
        return $user->id === $course->instructor_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Debug: Log the user role
        \Log::info('CoursePolicy::create - User ID: ' . $user->id . ', Role: ' . $user->role . ', isTeacher(): ' . ($user->isTeacher() ? 'true' : 'false'));
        
        // Only teachers can create courses
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Course $course): bool
    {
        // Only the instructor can update their own courses
        return $user->id === $course->instructor_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Course $course): bool
    {
        // Only the instructor can delete their own courses
        return $user->id === $course->instructor_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Course $course): bool
    {
        // Only the instructor can restore their own courses
        return $user->id === $course->instructor_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Course $course): bool
    {
        // Only the instructor can permanently delete their own courses
        return $user->id === $course->instructor_id;
    }
}