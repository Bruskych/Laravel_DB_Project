<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Note;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Attachment;

use App\Policies\NotePolicy;
use App\Policies\TaskPolicy;
use App\Policies\CommentPolicy;
use App\Policies\AttachmentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Note::class => NotePolicy::class,
        Task::class => TaskPolicy::class,
        Comment::class => CommentPolicy::class,
        Attachment::class => AttachmentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
