<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable;

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $guarded = [];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
   protected $hidden = [
      'password',
      'remember_token',
   ];


   
   
   /**
    * Generate a unique barcode for the user.
    */
   public static function generateUniqueBarcode()
   {
       $barcode = 'USR' . rand(10000000, 99999999);
       
       // Make sure the barcode is unique
       while (self::where('barcode', $barcode)->exists()) {
           $barcode = 'USR' . rand(10000000, 99999999);
       }
       
       return $barcode;
   }
   
   public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function getCurrentRoomAttribute()
    {
        $lastLog = $this->attendanceLogs()->orderBy('time', 'desc')->first();
        
        if ($lastLog && $lastLog->type == 'in') {
            return $lastLog->room;
        }
        
        return null;
    }

    public function getTimeInRoomAttribute($roomId)
    {
        $logs = $this->attendanceLogs()
            ->where('room_id', $roomId)
            ->orderBy('time')
            ->get();
        
        $totalTime = 0;
        $checkIn = null;
        
        foreach ($logs as $log) {
            if ($log->type == 'in') {
                $checkIn = $log->time;
            } else if ($log->type == 'out' && $checkIn) {
                $totalTime += strtotime($log->time) - strtotime($checkIn);
                $checkIn = null;
            }
        }
        
        return $totalTime; // in seconds
    }
}
