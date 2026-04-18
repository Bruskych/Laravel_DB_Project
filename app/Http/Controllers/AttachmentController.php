<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Throwable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttachmentController extends Controller
{
    use AuthorizesRequests;

    /**
     * GET /notes/{note}/attachments
     * - môže vidieť každý, kto vidí note (policy Note)
     */
    public function index(Note $note)
    {
        $this->authorize('view', $note);
        return response()->json(['attachments' => $note->attachments()->latest()->get(),], Response::HTTP_OK);
    }

    /**
     * POST /notes/{note}/attachments
     * - iba premium + autor alebo admin
     */
    public function store(Request $request, Note $note)
    {
        // policy: len autor alebo admin
        $this->authorize('create', [Attachment::class, $note]);

        $validated = $request->validate([
            'files' => ['required', 'array', 'min:1', 'max:10'],
            'files.*' => [
                'required',
                File::types(['pdf', 'jpg', 'jpeg', 'png'])->max('5mb')
            ],
        ]);

        $disk = 'public';
        $created = [];
        $storedPaths = [];

        try {
            DB::beginTransaction();

            foreach ($validated['files'] as $file) {

                $directory = "attachments/notes/{$note->id}/" . now()->format('Y/m');

                $path = $file->store($directory, $disk);

                $storedPaths[] = $path;

                $created[] = $note->attachments()->create([
                    'public_id' => (string) Str::ulid(),
                    'collection' => 'attachment',
                    'visibility' => 'private',
                    'disk' => $disk,
                    'path' => $path,
                    'stored_name' => basename($path),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }

            DB::commit();

        } catch (Throwable $e) {

            DB::rollBack();

            foreach ($storedPaths as $path) {
                Storage::disk($disk)->delete($path);
            }

            return response()->json([
                'message' => 'Prílohy sa nepodarilo uložiť.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Prílohy boli nahrané.',
            'attachments' => $created,
        ], Response::HTTP_CREATED);
    }

    /**
     * GET temporary download link
     * - každý kto vidí note môže stiahnuť
     */
    public function link(Attachment $attachment)
    {
        $this->authorize('view', $attachment);

        $note = $attachment->attachable;

        if (!$note || !$note->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $expiresAt = now()->addSeconds(60);

        return response()->json([
            'url' => Storage::disk($attachment->disk)
                ->temporaryUrl($attachment->path, $expiresAt),
            'expires_at' => $expiresAt,
        ]);
    }

    /**
     * DELETE attachment
     * - iba autor note alebo admin
     */
    public function destroy(Attachment $attachment)
    {
        $this->authorize('delete', $attachment);

        Storage::disk($attachment->disk)->delete($attachment->path);
        $attachment->delete();

        return response()->json(['message' => 'Príloha bola odstránená.'], Response::HTTP_OK);
    }
}
