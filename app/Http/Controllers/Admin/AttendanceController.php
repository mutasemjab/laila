<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\Room;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AttendanceController extends Controller
{
    public function scanBarcode(Request $request)
    {
        $request->validate([
            'user_barcode' => 'required|exists:users,barcode',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $user = User::where('barcode', $request->user_barcode)->first();
        $room = Room::findOrFail($request->room_id);
        
        // Check if user is active
        if ($user->activate != 1) {
            return response()->json([
                'success' => false,
                'message' => 'المستخدم غير نشط'
            ], 403);
        }
        
        // Get the last log entry for this user
        $lastLog = AttendanceLog::where('user_id', $user->id)
            ->orderBy('time', 'desc')
            ->first();
        
        $newType = 'in'; // Default to check-in
        
        if ($lastLog) {
            // If the user's last action was checking in to this same room, then check out
            if ($lastLog->type == 'in' && $lastLog->room_id == $room->id) {
                $newType = 'out';
                
                // Decrease room occupancy
                $room->decrement('current_occupancy');
            } 
            // If user was checked in to a different room, force check out from there first
            else if ($lastLog->type == 'in' && $lastLog->room_id != $room->id) {
                // Create automatic check-out from previous room
                AttendanceLog::create([
                    'user_id' => $user->id,
                    'room_id' => $lastLog->room_id,
                    'time' => Carbon::now(),
                    'type' => 'out'
                ]);
                
                // Decrease previous room occupancy
                $previousRoom = Room::findOrFail($lastLog->room_id);
                $previousRoom->decrement('current_occupancy');
                
                // And then we'll check in to the new room
                $newType = 'in';
                
                // Increase current room occupancy
                $room->increment('current_occupancy');
            }
            // If the user's last action was checking out (from any room), then check in
            else if ($lastLog->type == 'out') {
                $newType = 'in';
                
                // Increase room occupancy
                $room->increment('current_occupancy');
            }
        } else {
            // First time check-in
            $room->increment('current_occupancy');
        }
        
        // Create the new log entry
        $log = AttendanceLog::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'time' => Carbon::now(),
            'type' => $newType
        ]);
        
        // Update last check-in time if this is a check-in
        if ($newType == 'in') {
            $room->update(['last_check_in' => Carbon::now()]);
        }
        
        // Calculate time spent if user is checking out
        $timeSpent = null;
        if ($newType == 'out') {
            $checkInLog = AttendanceLog::where('user_id', $user->id)
                ->where('room_id', $room->id)
                ->where('type', 'in')
                ->orderBy('time', 'desc')
                ->first();
                
            if ($checkInLog) {
                $checkInTime = Carbon::parse($checkInLog->time);
                $checkOutTime = Carbon::parse($log->time);
                $timeSpent = $checkOutTime->diffInSeconds($checkInTime);
            }
        }
        
        // Get current room occupancy directly from the database
        $currentOccupancy = $room->current_occupancy;
        
        // Prepare last check-in time for display
        $lastCheckInTime = $room->last_check_in ? Carbon::parse($room->last_check_in)->diffForHumans() : 'لا يوجد';
        
        return response()->json([
            'success' => true,
            'message' => $newType == 'in' ? 'تم تسجيل الدخول بنجاح' : 'تم تسجيل الخروج بنجاح',
            'type' => $newType,
            'user' => $user->name,
            'room' => $room->name,
            'current_room_occupancy' => $currentOccupancy,
            'last_check_in' => $lastCheckInTime,
            'time_spent' => $timeSpent ? $this->formatTimeSpent($timeSpent) : null,
        ]);
    }
    
    public function validateBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        
        $userExists = User::where('barcode', $barcode)
            ->where('activate', 1)
            ->exists();
        
        return response()->json([
            'valid' => $userExists
        ]);
    }
    
    private function formatTimeSpent($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
    
    // Method to initialize all room occupancy counts
    public function initializeRoomOccupancy()
    {
        // Get all rooms
        $rooms = Room::all();
        
        foreach ($rooms as $room) {
            // Calculate current occupancy
            $currentOccupancy = AttendanceLog::whereIn('id', function ($query) use ($room) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('attendance_logs')
                    ->where('room_id', $room->id)
                    ->groupBy('user_id');
            })
            ->where('type', 'in')
            ->count();
            
            // Get last check-in time
            $lastCheckIn = AttendanceLog::where('room_id', $room->id)
                ->where('type', 'in')
                ->orderBy('time', 'desc')
                ->first();
            
            // Update room
            $room->update([
                'current_occupancy' => $currentOccupancy,
                'last_check_in' => $lastCheckIn ? $lastCheckIn->time : null
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث بيانات الغرف بنجاح'
        ]);
    }
}
