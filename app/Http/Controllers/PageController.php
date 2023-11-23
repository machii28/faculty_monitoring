<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
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
}
