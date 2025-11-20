<?php

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Upload a document for an application.
     * Only the owner can upload, and only while the application is PENDING.
     */
    public function store(Request $r, MembershipApplication $app)
    {
        // Owner-only
        abort_unless($app->user_id === auth()->id(), 403);

        // Stop uploads after approval/rejection (safety)
        abort_if($app->status !== 'pending', 403, 'Uploads are only allowed while your application is pending.');

        $r->validate([
            'type' => 'required|string|max:50',
            'file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ]);

        // Optional: prevent uploading the same document type twice
        $already = $app->documents()->where('type', $r->type)->exists();
        if ($already) {
            return back()->withErrors([
                'file' => "You already uploaded a {$r->type}. Delete it first if you want to replace it.",
            ])->withInput();
        }

        // Store on the public disk so /storage links work
        $path = $r->file('file')->store("documents/{$app->id}", 'public');

        Document::create([
            'membership_application_id' => $app->id,
            'type'          => $r->type,
            'path'          => $path,
            'original_name' => $r->file('file')->getClientOriginalName(),
            'mime'          => $r->file('file')->getMimeType(),
            'size'          => $r->file('file')->getSize(),
        ]);

        return back()->with('ok', 'Document uploaded.');
    }

    /**
     * Delete a document (only owner + pending).
     */
    public function destroy(Document $doc)
    {
        $application = $doc->application; // requires relation on Document model (see note below)

        // Owner check
        abort_unless($application->user_id === auth()->id(), 403);

        // Only while pending
        abort_if($application->status !== 'pending', 403, 'Cannot delete documents after review.');

        // Delete file and record
        Storage::disk('public')->delete($doc->path);
        $doc->delete();

        return back()->with('ok', 'Document removed successfully.');
    }
}
