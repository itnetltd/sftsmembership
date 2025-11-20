<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationContact extends Model
{
    protected $fillable = [
        'membership_application_id',
        'role','first_name','last_name','gender','phone','email',
    ];

    public function application()
    {
        return $this->belongsTo(MembershipApplication::class, 'membership_application_id');
    }
}
