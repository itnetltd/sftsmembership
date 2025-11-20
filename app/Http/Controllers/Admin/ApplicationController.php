<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * List all membership applications (latest first).
     */
    public function index()
    {
        $apps = MembershipApplication::with(['documents', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.applications.index', compact('apps'));
    }

    /**
     * Show a single application.
     */
    public function show(MembershipApplication $app)
    {
        $app->load(['documents', 'user']);
        return view('admin.applications.show', compact('app'));
    }

    /**
     * Approve an application.
     */
    public function approve(MembershipApplication $app, Request $request)
    {
        // optional: add admin note from $request->note
        $app->update([
            'status' => 'approved',
            // 'admin_notes' => $request->input('note'), // if you want to store notes
        ]);

        return back()->with('ok', 'Application approved.');
    }

    /**
     * Reject an application.
     */
    public function reject(MembershipApplication $app, Request $request)
    {
        $app->update([
            'status' => 'rejected',
            // 'admin_notes' => $request->input('note'), // if you want to store notes
        ]);

        return back()->with('ok', 'Application rejected.');
    }
}
