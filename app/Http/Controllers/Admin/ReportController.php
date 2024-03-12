<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class ReportController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ReportController extends Controller
{
    public function print()
    {
        $roomStats = Booking::select('rooms.id as room_id', 'rooms.room_number as room_name', 'rooms.building_number as building',
                DB::raw('SUM(TIMESTAMPDIFF(HOUR, STR_TO_DATE(start_booking_time, "%h:%i %p"), STR_TO_DATE(end_booking_time, "%h:%i %p"))) AS total_hours'),
                DB::raw('COUNT(*) AS total_bookings'))
            ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->groupBy('room_id')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.print', [
            'roomStats' => $roomStats
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('monitoring_sheet.pdf');
    }

    public function index()
    {
        $roomStats = Booking::select('rooms.id as room_id', 'rooms.room_number as room_name', 'rooms.building_number as building',
                DB::raw('SUM(TIMESTAMPDIFF(HOUR, STR_TO_DATE(start_booking_time, "%h:%i %p"), STR_TO_DATE(end_booking_time, "%h:%i %p"))) AS total_hours'),
                DB::raw('COUNT(*) AS total_bookings'))
            ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->groupBy('room_id')
            ->get();

        return view('admin.report', [
            'title' => 'Report',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'Report' => false,
            ],
            'page' => 'resources/views/admin/report.blade.php',
            'controller' => 'app/Http/Controllers/Admin/ReportController.php',
            'roomStats' => $roomStats
        ]);
    }

}
