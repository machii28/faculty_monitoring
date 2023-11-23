<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ScheduleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ScheduleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ScheduleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Schedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/schedule');
        CRUD::setEntityNameStrings('schedule', 'schedules');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // set columns from db columns.

        $this->crud->column([
            'label' => 'Subject',
            'type' => 'select',
            'name ' => 'subject_id',
            'attribute' => 'name',
            'entity' => 'subject'
        ]);

        $this->crud->column([
            'label' => 'Room',
            'type' => 'select',
            'name' => 'room_id',
            'attribute' => 'room_number',
            'entity' => 'room'
        ]);

        $this->crud->column([
            'label' => 'Professor',
            'type' => 'select',
            'name' => 'user_id',
            'attribute' => 'name',
            'entity' => 'user'
        ]);

        $this->crud->column([
            'label' => 'Year Level',
            'type' => 'text',
            'name' => 'year',
        ]);

        $this->crud->column([
            'label' => 'Semester',
            'type' => 'text',
            'name' => 'semester'
        ]);

        $this->crud->column([
            'label' => 'Time of Day',
            'type' => 'text',
            'name' => 'time'
        ]);

        $this->crud->column([
            'label' => 'Day of Week',
            'type' => 'text',
            'name' => 'day'
        ]);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ScheduleRequest::class);

        $this->crud->addField([
            'name' => 'subject_id',
            'type' => 'select',
            'model' => 'App\Models\Subject',
            'attribute' => 'name'
        ]);

        $this->crud->addField([
            'name' => 'room_id',
            'type' => 'select',
            'model' => 'App\Models\Room',
            'attribute' => 'room_number'
        ]);

        $this->crud->addField([
            'name' => 'user_id',
            'type' => 'select',
            'model' => 'App\Models\User',
            'attribute' => 'name',
            'options' => (function ($query) {
                return $query->where('role', 'faculty')->get();
            }),
        ]);

        $this->crud->addField([
            'name' => 'year',
            'type' => 'select_from_array',
            'options' => [
                '1st Year' => '1st Year',
                '2nd Year' => '2nd Year',
                '3rd Year' => '3rd Year',
                '4th Year' => '4th Year'
            ],
        ]);

        $this->crud->addField([
            'name' => 'semester',
            'type' => 'select_from_array',
            'options' => [
                '1st Semester' => '1st Semester',
                '2nd Semester' => '2nd Semester'
            ]
        ]);

        $this->crud->addField([
            'name' => 'start_time',
            'type' => 'time',
        ]);

        $this->crud->addField([
            'name' => 'end_time',
            'type' => 'time'
        ]);

        $this->crud->addField([
            'name' => 'day',
            'type' => 'select_from_array',
            'options' => [
                'Monday' => 'Monday',
                'Tuesday' => 'Tuesday',
                'Wednesday' => 'Wednesday',
                'Thursday' => 'Thursday',
                'Friday' => 'Friday',
                'Saturday' => 'Saturday',
                'Sunday' => 'Sunday'
            ]
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
