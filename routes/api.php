<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

// Custom
Route::get('notes/pinned', [NoteController::class, 'pinnedNotes']);
// Lesson 4
Route::apiResource('notes', NoteController::class);
Route::get('notes/stats/status', [NoteController::class, 'statsByStatus']);
Route::patch('notes/actions/archive-old-drafts', [NoteController::class, 'archiveOldDrafts']);
Route::get('users/{user}/notes', [NoteController::class, 'userNotesWithCategories']);
Route::get('notes-actions/search', [NoteController::class, 'search']);
