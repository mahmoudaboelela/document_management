<?php

namespace App\Policies;

use App\Models\DocumentHeader;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any documents.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //Allow all users to view documents
        return true;
    }

    /**
     * Determine whether the user can view the document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentHeader  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DocumentHeader $document)
    {
        //Only allow the owner of the document or an admin to view
        return $user->id === $document->user_id || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentHeader  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DocumentHeader $document)
    {
        //Only allow the owner of the document or an admin to update
        return $user->id === $document->user_id || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DocumentHeader  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DocumentHeader $document)
    {
        //Only allow the owner of the document or an admin to delete
        return $user->id === $document->user_id || $user->hasRole('Admin');
    }

}
