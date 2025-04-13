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

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'gender' => 'required|in:1,2',
            'category' => 'required|in:1,2,3',
            'phone' => 'required|string|max:255|unique:users',
            'activate' => 'required|in:1,2',
        ]);

        $user = new User();
        $user->title = $validatedData['title'];
        $user->first_name = $validatedData['first_name'];
        $user->second_name = $validatedData['second_name'];
        $user->last_name = $validatedData['last_name'];
        $user->company = $validatedData['company'];
        $user->country = $validatedData['country'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];
        $user->category = $validatedData['category'];
        $user->phone = $validatedData['phone'];
        $user->activate = $validatedData['activate'];
        $user->barcode = User::generateUniqueBarcode();
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified user and their barcode.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('admin.users.edit', compact('data'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'required|in:1,2',
            'category' => 'required|in:1,2,3',
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            'activate' => 'required|in:1,2',
        ]);

        $user->title = $validatedData['title'];
        $user->first_name = $validatedData['first_name'];
        $user->second_name = $validatedData['second_name'];
        $user->last_name = $validatedData['last_name'];
        $user->company = $validatedData['company'];
        $user->country = $validatedData['country'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];
        $user->category = $validatedData['category'];
        $user->phone = $validatedData['phone'];
        $user->activate = $validatedData['activate'];

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function showLogs($id)
    {
        // Get the user
        $user = User::findOrFail($id);
        
        // Get all rooms
        $rooms = Room::all();
        
        // Get all user attendance logs grouped by room
        $roomTimeLogs = [];
        
        foreach ($rooms as $room) {
            // Get all logs for this user in this room, ordered by time
            $logs = AttendanceLog::where('user_id', $user->id)
                ->where('room_id', $room->id)
                ->orderBy('time')
                ->get();
            
            // Calculate time spent and format attendance records
            $visits = [];
            $totalTimeInRoom = 0;
            
            // Process logs to pair check-ins with check-outs
            $checkIn = null;
            
            foreach ($logs as $log) {
                if ($log->type == 'in') {
                    $checkIn = $log;
                } else if ($log->type == 'out' && $checkIn) {
                    // Calculate time spent
                    $checkInTime = Carbon::parse($checkIn->time);
                    $checkOutTime = Carbon::parse($log->time);
                    $duration = $checkOutTime->diffInSeconds($checkInTime);
                    $totalTimeInRoom += $duration;
                    
                    // Add to visits
                    $visits[] = [
                        'check_in_time' => $checkInTime,
                        'check_out_time' => $checkOutTime,
                        'duration' => $this->formatDuration($duration),
                        'duration_seconds' => $duration
                    ];
                    
                    $checkIn = null;
                }
            }
            
            // Handle case where user is still in room (no check-out)
            if ($checkIn) {
                $visits[] = [
                    'check_in_time' => Carbon::parse($checkIn->time),
                    'check_out_time' => null,
                    'duration' => 'مازال في الغرفة',
                    'duration_seconds' => Carbon::now()->diffInSeconds(Carbon::parse($checkIn->time))
                ];
            }
            
            // Add room data with visits
            if (!empty($visits)) {
                $roomTimeLogs[] = [
                    'room' => $room,
                    'visits' => $visits,
                    'total_time' => $this->formatDuration($totalTimeInRoom),
                    'total_seconds' => $totalTimeInRoom
                ];
            }
        }
        
        // Sort rooms by total time spent (descending)
        usort($roomTimeLogs, function($a, $b) {
            return $b['total_seconds'] - $a['total_seconds'];
        });
        
        return view('admin.users.showLog', compact('user', 'roomTimeLogs'));
    }
    
    private function formatDuration($seconds)
    {
        if ($seconds < 60) {
            return $seconds . ' ثانية';
        }
        
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        
        if ($minutes < 60) {
            return $minutes . ' دقيقة ' . ($remainingSeconds > 0 ? 'و ' . $remainingSeconds . ' ثانية' : '');
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        $formattedTime = $hours . ' ساعة';
        
        if ($remainingMinutes > 0) {
            $formattedTime .= ' و ' . $remainingMinutes . ' دقيقة';
        }
        
        if ($remainingSeconds > 0 && $remainingMinutes == 0) {
            $formattedTime .= ' و ' . $remainingSeconds . ' ثانية';
        }
        
        return $formattedTime;
    }
}
