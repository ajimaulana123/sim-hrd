<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeaveRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Both admin and employees can view leave requests
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeaveRequest $leaveRequest): bool
    {
        // Admin can view all leave requests
        if ($user->role === 'admin') {
            return true;
        }

        // Employees can only view their own leave requests
        return $user->employee_id === $leaveRequest->employee_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Both admin and employees can create leave requests
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeaveRequest $leaveRequest): bool
    {
        // Admin can update all leave requests
        if ($user->role === 'admin') {
            return true;
        }

        // Employees can only update their own pending leave requests
        return $user->employee_id === $leaveRequest->employee_id && 
               $leaveRequest->status === 'pending';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeaveRequest $leaveRequest): bool
    {
        // Admin can delete any leave request
        if ($user->role === 'admin') {
            return true;
        }

        // Employees can only delete their own pending leave requests
        return $user->employee_id === $leaveRequest->employee_id && 
               $leaveRequest->status === 'pending';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->role === 'admin';
    }

    public function approve(User $user, LeaveRequest $leaveRequest): bool
    {
        // Only admin can approve leave requests
        return $user->role === 'admin';
    }

    public function reject(User $user, LeaveRequest $leaveRequest): bool
    {
        // Only admin can reject leave requests
        return $user->role === 'admin';
    }
}
