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


   public function attendanceLogs()
   {
       return $this->hasMany(AttendanceLog::class);
   }
   
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
   
   /**
    * Calculate total time spent by user inside the premises.
    */
   public function calculateTotalTimeInside()
   {
       $logs = $this->attendanceLogs()->orderBy('time')->get();
       $totalTimeInSeconds = 0;
       $inTime = null;
       
       foreach ($logs as $log) {
           if ($log->type == 'in') {
               $inTime = strtotime($log->time);
           } elseif ($log->type == 'out' && $inTime) {
               $outTime = strtotime($log->time);
               $totalTimeInSeconds += ($outTime - $inTime);
               $inTime = null;
           }
       }
       
       // If there's an "in" without a corresponding "out", consider the current time
       if ($inTime) {
           $currentTime = time();
           $totalTimeInSeconds += ($currentTime - $inTime);
       }
       
       // Return the total time in seconds
       return $totalTimeInSeconds;
   }
   
   /**
    * Format the total time into a human-readable format.
    */
   public function formattedTotalTime()
   {
       $totalSeconds = $this->calculateTotalTimeInside();
       $hours = floor($totalSeconds / 3600);
       $minutes = floor(($totalSeconds % 3600) / 60);
       $seconds = $totalSeconds % 60;
       
       return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
   }

}
