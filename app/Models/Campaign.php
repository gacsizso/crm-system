<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'subject',
        'body',
        'sent',
        'sent_at',
        'created_by',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'campaign_group');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
