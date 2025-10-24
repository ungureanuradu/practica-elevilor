<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any jobs.
     */
    public function viewAny(User $user)
    {
        return true; // Anyone can view jobs
    }

    /**
     * Determine whether the user can view the job.
     */
    public function view(User $user, Job $job)
    {
        return true; // Anyone can view jobs
    }

    /**
     * Determine whether the user can create jobs.
     */
    public function create(User $user)
    {
        return $user->isCompany(); // Only companies can create jobs
    }

    /**
     * Determine whether the user can update the job.
     */
    public function update(User $user, Job $job)
    {
        return $user->isCompany() && $user->id === $job->company_id;
    }

    /**
     * Determine whether the user can delete the job.
     */
    public function delete(User $user, Job $job)
    {
        return $user->isCompany() && $user->id === $job->company_id;
    }

    /**
     * Determine whether the user can restore the job.
     */
    public function restore(User $user, Job $job)
    {
        return $user->isCompany() && $user->id === $job->company_id;
    }

    /**
     * Determine whether the user can permanently delete the job.
     */
    public function forceDelete(User $user, Job $job)
    {
        return $user->isCompany() && $user->id === $job->company_id;
    }

    /**
     * Determine whether the user can view applications for the job.
     */
    public function viewApplications(User $user, Job $job)
    {
        return $user->isCompany() && $user->id === $job->company_id;
    }
}
