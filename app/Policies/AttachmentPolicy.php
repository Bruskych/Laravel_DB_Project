<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Note;
use App\Models\Task;
use App\Models\Attachment;

class AttachmentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // you can see it if you see it
    public function view(User $user, Attachment $attachment): bool
    {
        $note = $attachment->attachable;
        if (!$note instanceof \App\Models\Note) {
            return false;
        }
        return $user->can('view', $note);
    }

    public function create(User $user, Note $note): bool
    {
        return $user->hasActivePremium() && ($user->isAdmin() || $note->user_id === $user->id);
    }

    public function delete(User $user, Attachment $attachment): bool
    {
        $note = $attachment->attachable;
        return $note && ($user->isAdmin() || $note->user_id === $user->id);
    }

    private function canAccessNote(User $user, Attachment $attachment): bool
    {
        $note = $attachment->attachable;
        if ($note->status === 'published' || $note->status === 'archived') {
            return true;
        }
        return $note->user_id === $user->id;
    }
}
