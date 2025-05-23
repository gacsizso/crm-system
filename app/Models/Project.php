<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
        'deadline',
        'hourly_rate',
        'hours',
        'currency',
        'note',
        'created_by',
        'contact_id',
        'group_id',
        'manager_id',
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_project');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class);
    }
}
