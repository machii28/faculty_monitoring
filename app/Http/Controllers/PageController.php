<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function scan(Request $request)
    {
        return view('scan');
    }

    public function schedules(Request $request)
    {
        $schedules = Schedule::where('user_id', auth()->id())
            ->get();

        $data['schedules'] = $schedules;

        return view('schedules', $data);
    }

    public function bundy($roomId, Request $request)
    {
        $day = now()->timezone('Asia/Singapore')->format('l');
        $time = now()->timezone('Asia/Singapore')->toTimeString();
//
//        $schedule = Schedule::where('room_id', $roomId)
//            ->where('user_id', auth()->id())
//            ->first();
//
//        if (!$schedule) {
//            return response()->json([
//                'message' => 'No Schedule For This Room'
//            ]);
//        }
//
//        if ($schedule->day !== $day) {
//            return response()->json([
//                'message' => 'Its not your schedule'
//            ]);
//        }
//
//        if (!($schedule->start_time <= $time && $schedule->end_time >= $time)) {
//            return response()->json([
//                'message' => 'Its not your schedule'
//            ]);
//        }

        $attendance = Attendance::where('room_id', $roomId)
            ->where('user_id', auth()->id())
            ->where('date_clocked_in', now()->toDateString())
            ->first();

        if (!$attendance) {
            $attendance = new Attendance();
            $attendance->room_id = $roomId;
            $attendance->user_id = auth()->id();
            $attendance->time_in = $time;
            $attendance->date_clocked_in = now()->toDateString();
            $attendance->save();

            return response()->json([
                'message' => 'Clock In Successfully'
            ]);
        }

        $attendance->time_out = $time;
        $attendance->save();

        return response()->json([
            'message' => 'Clock Out Successfully'
        ]);
    }
}
