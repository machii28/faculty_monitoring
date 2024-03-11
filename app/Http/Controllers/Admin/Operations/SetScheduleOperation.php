<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait SetScheduleOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupSetScheduleRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{userId}/set-schedule', [
            'as'        => $routeName.'.setSchedule',
            'uses'      => $controller.'@setSchedule',
            'operation' => 'setSchedule',
        ]);

        Route::get($segment . '/{userId}/create-schedule', [
            'as' => $routeName. '.createSchedule',
            'uses' => $controller . '@createSchedule',
            'operation' => 'setSchedule'
        ]);

        Route::post($segment . '/{userId}/save-schedule', [
            'as' => $routeName . '.saveSchedule',
            'uses' => $controller . '@saveSchedule',
            'operation' => 'setSchedule'
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupSetScheduleDefaults()
    {
        CRUD::allowAccess('setSchedule');

        CRUD::operation('setSchedule', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'set_schedule', 'view', 'crud::buttons.set_schedule');
             CRUD::addButton('line', 'set_schedule', 'view', 'crud::buttons.set_schedule');
        });
    }

    public function setSchedule($userId)
    {
        CRUD::hasAccessOrFail('setSchedule');
        $faculty = User::find($userId);

        $schedules = Schedule::with(['subject', 'room', 'user'])->where('user_id', $userId);

        if (request()->has('semester')) {
            $schedules = $schedules->where('semester', request()->get('semester'));
        }

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Set Schedule '.$this->crud->entity_name;
        $this->data['facultyName'] = $faculty->full_name;
        $this->data['userId'] = $userId;
        $this->data['schedules'] = $schedules->get();

        // load the view
        return view('crud::operations.set_schedule', $this->data);
    }

    public function createSchedule($userId)
    {
        CRUD::hasAccessorFail('setSchedule');

        $this->data['subjects'] = Subject::all();
        $this->data['rooms'] = Room::all();

        return view('crud::operations.create_schedule', $this->data);
    }
}
