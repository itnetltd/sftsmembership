<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use Illuminate\Http\Request;

class ApplicationReviewController extends Controller
{
    public function index()
    {
        $applications = MembershipApplication::with('documents', 'user')
            ->latest()
            ->get();

        return view('admin.applications.index', compact('applications'));
    }

    public function show(MembershipApplication $application)
    {
        $application->load('documents', 'user');
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $r, MembershipApplication $application)
    {
        $r->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $application->update([
            'status' => $r->status,
        ]);

        return redirect()
            ->route('admin.applications.index')
            ->with('ok', 'Application ' . ucfirst($r->status) . ' successfully.');
    }
}
