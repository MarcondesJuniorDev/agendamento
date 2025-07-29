<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'duration_minutes',
        'price',
    ];

    /**
     * Get the duration in a human-readable format.
     *
     * @return string
     */
    public function getDurationFormattedAttribute()
    {
        return "{$this->duration_minutes} minutes";
    }

    public function professionals()
    {
        return $this->belongsToMany(Professional::class, 'professional_service');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
