<?php

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Show the RAM membership application form.
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
     * Store a new membership application (RAM + PSF fields).
     */
    public function store(Request $r)
    {
        $validated = $r->validate([
            // existing:
            'company_name'        => 'required|string|max:255',
            'sector'              => 'nullable|string|max:255',
            'location'            => 'nullable|string|max:255',
            'company_website'     => 'nullable|url|max:255',
            'products_services'   => 'nullable|string',

            // PSF: membership
            'membership_type'     => 'nullable|in:Champions,Ordinary,Golden Circle',
            'chamber'             => 'nullable|string|max:255',
            'association'         => 'nullable|string|max:255',
            'cluster_name'        => 'nullable|string|max:255',

            // PSF: registration
            'registration_type'   => 'nullable|in:TIN,Company code,Patent,RCA Number',
            'registration_number' => 'nullable|string|max:255',

            // PSF: address/contact
            'phone'        => 'nullable|string|max:50',
            'fax'          => 'nullable|string|max:50',
            'po_box'       => 'nullable|string|max:100',
            'street'       => 'nullable|string|max:255',
            'building'     => 'nullable|string|max:255',
            'quartier'     => 'nullable|string|max:255',
            'province'     => 'nullable|string|max:100',
            'district'     => 'nullable|string|max:100',
            'sector_admin' => 'nullable|string|max:100',
            'cell'         => 'nullable|string|max:100',

            // PSF: profile
            'company_type'               => 'nullable|string|max:100',
            'ownership'                  => 'nullable|string|max:100',
            'business_activity'          => 'nullable|string|max:255',
            'business_activity_detail'   => 'nullable|string',
            'export_import'              => 'nullable|string',
            'export_import_countries'    => 'nullable|string',
            'employees_perm'             => 'nullable|string|max:30',
            'employees_part'             => 'nullable|string|max:30',

            // Contacts array
            'contacts'                 => 'array',
            'contacts.*.role'          => 'nullable|string|max:100',
            'contacts.*.first_name'    => 'nullable|string|max:100',
            'contacts.*.last_name'     => 'nullable|string|max:100',
            'contacts.*.gender'        => 'nullable|in:Male,Female',
            'contacts.*.phone'         => 'nullable|string|max:50',
            'contacts.*.email'         => 'nullable|email|max:255',
        ]);

        // Normalize website if present
        if (!empty($validated['company_website'])) {
            $validated['company_website'] = $this->normalizeWebsite($validated['company_website']);
        }

        $app = DB::transaction(function () use ($validated) {
            $app = MembershipApplication::create([
                'user_id'      => auth()->id(),
                'status'       => 'pending',
                'submitted_at' => now(),

                // existing:
                'company_name'        => $validated['company_name'],
                'sector'              => $validated['sector'] ?? null,
                'location'            => $validated['location'] ?? null,
                'company_website'     => $validated['company_website'] ?? null,
                'products_services'   => $validated['products_services'] ?? null,

                // PSF:
                'membership_type'     => $validated['membership_type'] ?? null,
                'chamber'             => $validated['chamber'] ?? null,
                'association'         => $validated['association'] ?? null,
                'cluster_name'        => $validated['cluster_name'] ?? null,

                'registration_type'   => $validated['registration_type'] ?? null,
                'registration_number' => $validated['registration_number'] ?? null,

                'phone'        => $validated['phone'] ?? null,
                'fax'          => $validated['fax'] ?? null,
                'po_box'       => $validated['po_box'] ?? null,
                'street'       => $validated['street'] ?? null,
                'building'     => $validated['building'] ?? null,
                'quartier'     => $validated['quartier'] ?? null,
                'province'     => $validated['province'] ?? null,
                'district'     => $validated['district'] ?? null,
                'sector_admin' => $validated['sector_admin'] ?? null,
                'cell'         => $validated['cell'] ?? null,

                'company_type'               => $validated['company_type'] ?? null,
                'ownership'                  => $validated['ownership'] ?? null,
                'business_activity'          => $validated['business_activity'] ?? null,
                'business_activity_detail'   => $validated['business_activity_detail'] ?? null,
                'export_import'              => $validated['export_import'] ?? null,
                'export_import_countries'    => $validated['export_import_countries'] ?? null,
                'employees_perm'             => $validated['employees_perm'] ?? null,
                'employees_part'             => $validated['employees_part'] ?? null,
            ]);

            // Contacts (optional)
            if (!empty($validated['contacts'])) {
                foreach ($validated['contacts'] as $c) {
                    // avoid empty rows (all-null fields)
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
     * Normalize the website field to include https:// if missing.
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
