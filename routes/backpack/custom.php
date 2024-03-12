<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('faculty', 'FacultyCrudController');
    Route::crud('schedule', 'ScheduleCrudController');
    Route::crud('room', 'RoomCrudController');
    Route::crud('subject', 'SubjectCrudController');
    Route::crud('attendance', 'AttendanceCrudController');
    Route::crud('booking', 'BookingCrudController');
    Route::get('test', 'TestController@index')->name('page.test.index');
    Route::get('settings', 'SettingsController@index')->name('page.settings.index');
    Route::get('schedule_of_the_day', 'ScheduleOfTheDayController@index')->name('page.schedule_of_the_day.index');
    Route::get('report', 'ReportController@index')->name('page.report.index');
    Route::get('print-report', 'ReportController@print')->name('page.report.print');
}); // this should be the absolute last line of this file
