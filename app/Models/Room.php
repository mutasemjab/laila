<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $casts = [
        'last_check_in' => 'datetime',
    ];
    
    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function getCurrentOccupancyAttribute()
    {
        // Get count of users currently in the room (users with 'in' as last action)
        $userIds = $this->attendanceLogs()
            ->select('user_id')
            ->orderBy('time', 'desc')
            ->groupBy('user_id')
            ->havingRaw('MAX(type) = "in"')
            ->pluck('user_id');
            
        return count($userIds);
    }
}
