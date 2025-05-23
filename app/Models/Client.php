<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

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
