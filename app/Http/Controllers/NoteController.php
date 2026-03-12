<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Note::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Note::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Note::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note = Note::findOrFail($id);
        $note->update($request->all());
        return $note;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json(['message' => 'Note deleted']);
    }

    // GET /api/notes/stats/status
    public function statsByStatus()
    {
        return ['total_notes' => Note::count()];
    }


    // PATCH /api/notes/actions/archive-old-drafts
    public function archiveOldDrafts()
    {
        return response()->json(['message' => 'Old drafts archived (example)']);
    }

    // GET /api/users/{user}/notes
    public function userNotesWithCategories($user)
    {
        return Note::where('user_id', $user)->get();
    }

    // GET /api/notes-actions/search?q=text
    public function search(Request $request)
    {
        $query = strtolower($request->q);
        return Note::whereRaw('LOWER(title) like ?', ["%{$query}%"])->get();
    }

    // GET /api/notes/pinned
    public function pinnedNotes()
    {
        return Note::where('is_pinned', 1)->get();
    }
}
