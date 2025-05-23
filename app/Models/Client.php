<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'type',
        'added_by',
        'added_at',
        'notes',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_client');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'client_project');
    }
}
