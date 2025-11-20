<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'membership_application_id','type','path','original_name','mime','size'
    ];

    
    public function application()
{
    return $this->belongsTo(\App\Models\MembershipApplication::class, 'membership_application_id');
}

}
