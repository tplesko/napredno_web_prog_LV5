<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'naziv_rada_hr',
        'naziv_rada_en',
        'zadatak_rada_hr',
        'zadatak_rada_en',
        'tip_studija',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function acceptedApplication()
    {
        return $this->hasOne(Application::class)->where('status', 'accepted');
    }

    // Helper metode za trenutni jezik
    public function getNazivAttribute()
    {
        return app()->getLocale() === 'en' ? $this->naziv_rada_en : $this->naziv_rada_hr;
    }

    public function getZadatakAttribute()
    {
        return app()->getLocale() === 'en' ? $this->zadatak_rada_en : $this->zadatak_rada_hr;
    }
}