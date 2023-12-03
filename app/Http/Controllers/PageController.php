<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function scan(Request $request)
    {
        return view('scan');
    }

    public function bookings(Request $request)
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->get();

        $data['bookings'] = $bookings;

        return view('bookings', $data);
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
        $now = now()->timezone('Asia/Singapore');
        $day = $now->toDateString();
        $time = $now->format('g:i A');

        if (is_null($request->get('subject'))) {
            return response()->json([
                'message'  => 'Please provide a valid subject'
            ]);
        }

        $subject = Subject::where('code', $request->get('subject'))->first();

        if (!$subject) {
            return response()->json([
                'message'  => 'Please provide a valid subject'
            ]);
        }

        $existingBooking = Booking::where('user_id', auth()->id())
            ->where('booking_date', $now->toDateString())
            ->whereNull('end_booking_time')
            ->first();

        $room = Room::find($roomId);

        if ($existingBooking) {
            if ($existingBooking?->room_id !== (int) $roomId) {
                return response()->json([
                    'message' => 'You are currently booked to another room'
                ]);
            }

            if ($existingBooking?->room_id === (int) $roomId) {
                $existingBooking->end_booking_time = $time;
                $existingBooking->save();

                $room->is_occupied = false;
                $room->save();

                return response()->json([
                    'message' => 'Room Booked Out Successfully'
                ]);
            }
        }

        $booking = new Booking();
        $booking->booking_date = $day;
        $booking->room_id = $room->id;
        $booking->user_id = auth()->id();
        $booking->subject_id = $subject->id;
        $booking->start_booking_time = $time;
        $booking->save();

        $room->is_occupied = true;
        $room->save();

        return response()->json([
            'message' => 'Room Booked In Successfully'
        ]);
    }

    public function bundya($roomId, Request $request)
    {
        $day = now()->timezone('Asia/Singapore')->format('l');
        $time = now()->timezone('Asia/Singapore')->toTimeString();

        $schedule = Schedule::where('room_id', $roomId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$schedule) {
            return response()->json([
                'message' => 'No Schedule For This Room'
            ]);
        }

        if ($schedule->day !== $day) {
            return response()->json([
                'message' => 'Its not your schedule'
            ]);
        }

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
                'message' => 'Time Recorded Successfully'
            ]);
        }

        $attendance->time_out = $time;
        $attendance->save();

        return response()->json([
            'message' => 'Time Recorded Successfully'
        ]);
    }
}
