<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checklist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'time',
        'brand',
        'plate',
        'mirror',
        'disc',
        'jacket',
        'tire',
        'helmet',
        'vehicle_condition',
        'notes',
        'status',
        'chief_approved',
        'supervisor_approved',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'time' => 'datetime',
        'chief_approved' => 'boolean',
        'supervisor_approved' => 'boolean',
    ];

    /**
     * Relationship to the user who created the checklist.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship to the creator (if tracked separately).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship to the last updater (if tracked).
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
