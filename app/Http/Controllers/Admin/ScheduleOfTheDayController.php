<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

/**
 * Class ScheduleOfTheDayController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ScheduleOfTheDayController extends Controller
{
    public function index()
    {
        return view('admin.schedule_of_the_day', [
            'title' => 'Schedule Of The Day',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'ScheduleOfTheDay' => false,
            ],
            'page' => 'resources/views/admin/schedule_of_the_day.blade.php',
            'controller' => 'app/Http/Controllers/Admin/ScheduleOfTheDayController.php',
        ]);
    }
}
