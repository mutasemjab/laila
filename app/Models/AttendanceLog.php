<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'time',
        'type',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'time' => 'datetime',
    ];
    
    /**
     * Get the user that owns the attendance log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
