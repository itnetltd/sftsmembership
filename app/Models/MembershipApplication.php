<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    protected $fillable = [
        'user_id','status','submitted_at',
        'company_name','sector','location','company_website','products_services',

        // PSF additions
        'membership_type','chamber','association','cluster_name',
        'registration_type','registration_number',
        'phone','fax','po_box','street','building','quartier',
        'province','district','sector_admin','cell',
        'company_type','ownership','business_activity','business_activity_detail',
        'export_import','export_import_countries',
        'employees_perm','employees_part',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    protected $attributes = [
        // in case nothing is set during creation, keep consistent default
        'status' => 'pending',
    ];

    /** Documents uploaded for this application */
    public function documents()
    {
        return $this->hasMany(Document::class, 'membership_application_id');
    }

    /** Contact persons tied to this application (Owner/MD/HR/etc.) */
    public function contacts()
    {
        return $this->hasMany(ApplicationContact::class, 'membership_application_id');
    }

    /** The applicant (owner user record) */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Payments linked to this application (optional, for billing linkage) */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'membership_application_id');
    }

    /**
     * Accessor: ensure website is always shown with protocol when present.
     * (Non-breaking: it doesn’t write to DB; only formats when reading.)
     */
    public function getCompanyWebsiteAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return preg_match('~^https?://~i', $value) ? $value : 'https://' . $value;
    }
}
