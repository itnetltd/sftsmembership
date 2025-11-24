<?php 

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Show the SFTS membership application form.
     * Redirects if the user already has a pending or approved application.
     */
    public function create()
    {
        $existing = MembershipApplication::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()
                ->route('application.show', $existing)
                ->with('info', 'You already have an application.');
        }

        return view('application.create');
    }

    /**
     * Store a new membership application (Shoot For The Stars).
     */
    public function store(Request $r)
    {
        $validated = $r->validate([
            // Core fields (renamed meaning but same columns)
            'company_name'      => 'required|string|max:255',  // Player full name
            'sector'            => 'nullable|string|max:255',  // Age category (U12, U10…)
            'location'          => 'nullable|string|max:255',  // Training venue

            // Parent contact
            'company_website'   => 'nullable|email|max:255',   // Parent / guardian email
            'phone'             => 'nullable|string|max:50',   // Parent / guardian phone

            // Program / membership
            'membership_type'   => 'nullable|in:Practice Only,Full Program + Game Day,Shooting Clinics',
            'chamber'           => 'nullable|string|max:255',  // Team / division
            'association'       => 'nullable|string|max:255',  // School
            'cluster_name'      => 'nullable|string|max:255',  // Jersey name / number

            // Player notes
            'products_services' => 'nullable|string',

            // Contacts array (kept for future use, safe even if form doesn’t send it)
            'contacts'                 => 'array',
            'contacts.*.role'          => 'nullable|string|max:100',
            'contacts.*.first_name'    => 'nullable|string|max:100',
            'contacts.*.last_name'     => 'nullable|string|max:100',
            'contacts.*.gender'        => 'nullable|in:Male,Female',
            'contacts.*.phone'         => 'nullable|string|max:50',
            'contacts.*.email'         => 'nullable|email|max:255',
        ]);

        // NOTE: previously we normalized company_website as a URL.
        // Now this field is used as parent email, so no normalization is needed.

        $app = DB::transaction(function () use ($validated) {
            $app = MembershipApplication::create([
                'user_id'      => auth()->id(),
                'status'       => 'pending',
                'submitted_at' => now(),

                // Core fields
                'company_name'      => $validated['company_name'],
                'sector'            => $validated['sector'] ?? null,
                'location'          => $validated['location'] ?? null,
                'company_website'   => $validated['company_website'] ?? null,
                'phone'             => $validated['phone'] ?? null,
                'products_services' => $validated['products_services'] ?? null,

                // Program / membership
                'membership_type'   => $validated['membership_type'] ?? null,
                'chamber'           => $validated['chamber'] ?? null,
                'association'       => $validated['association'] ?? null,
                'cluster_name'      => $validated['cluster_name'] ?? null,
            ]);

            // Contacts (optional – only created if some data is provided)
            if (!empty($validated['contacts'])) {
                foreach ($validated['contacts'] as $c) {
                    if (is_array($c) && array_filter($c, fn($v) => $v !== null && $v !== '')) {
                        $app->contacts()->create($c);
                    }
                }
            }

            return $app;
        });

        return redirect()
            ->route('application.show', $app)
            ->with('ok', 'Application submitted! You can now upload required documents.');
    }

    /**
     * Show the user's application with uploaded documents.
     */
    public function show(MembershipApplication $app)
    {
        abort_unless($app->user_id === auth()->id(), 403);
        $app->load('documents', 'contacts');

        return view('application.show', compact('app'));
    }

    /**
     * Old helper kept for compatibility. Not used now because company_website stores email.
     */
    private function normalizeWebsite(?string $url): ?string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }

        if (!preg_match('~^https?://~i', $url)) {
            $url = 'https://' . $url;
        }

        return $url;
    }
}
