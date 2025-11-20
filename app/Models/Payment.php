<?php

namespace App\Models;

use App\Models\User;
use App\Models\MembershipApplication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'membership_application_id', // FK to membership_applications (nullable is fine)
        'amount',
        'currency',
        'method',
        'status',
        'transaction_id',
        'reference',
        'paid_at',
        'meta',
    ];

    protected $casts = [
        'amount'  => 'integer',
        'paid_at' => 'datetime',
        'meta'    => 'array',   // <-- ensures arrays save/load cleanly
    ];

    // sensible default currency
    protected $attributes = [
        'currency' => 'RWF',
    ];

    /* Relationships */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Links a payment to the RAM membership application
    public function application()
    {
        // Explicit FK so with(['application']) works
        return $this->belongsTo(MembershipApplication::class, 'membership_application_id');
    }
    
}
