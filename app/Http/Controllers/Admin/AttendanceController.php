<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AttendanceController extends Controller
{

  /**
     * Display the barcode scanner view.
     */
    public function scannerView()
    {
        return view('admin.attendance.scanner');
    }
    
    /**
     * Process the barcode scan.
     */
    public function processScan(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
            'type' => 'required|in:in,out',
        ]);
        
        $barcode = $request->input('barcode');
        $type = $request->input('type');
        
        $user = User::where('barcode', $barcode)->first();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Invalid barcode'], 400);
        }
        
        // Create a new attendance log
        $log = new AttendanceLog();
        $log->user_id = $user->id;
        $log->time = Carbon::now();
        $log->type = $type;
        $log->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'type' => $type,
                'time' => $log->time->format('Y-m-d H:i:s'),
            ],
        ]);
    }
    
    /**
     * Show attendance logs for a specific user.
     */
    public function showUserLogs(User $user)
    {
        $logs = $user->attendanceLogs()->orderBy('time', 'desc')->paginate(15);
        $totalTime = $user->formattedTotalTime();
        
        return view('admin.attendance.user_logs', compact('user', 'logs', 'totalTime'));
    }
    
    /**
     * Show all attendance logs.
     */
    public function showAllLogs()
    {
        $logs = AttendanceLog::with('user')->orderBy('time', 'desc')->paginate(20);
        return view('admin.attendance.all_logs', compact('logs'));
    }
    
    /**
     * Calculate total time for a user.
     */
    public function calculateTime(User $user)
    {
        $totalTime = $user->formattedTotalTime();
        $totalSeconds = $user->calculateTotalTimeInside();
        
        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'total_time_formatted' => $totalTime,
            'total_seconds' => $totalSeconds,
        ]);
    }
}
