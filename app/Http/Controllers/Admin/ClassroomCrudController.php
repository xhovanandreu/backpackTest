<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClassroomRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Events\ClassroomCreated;
use App\Models\Classroom;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;

/**
 * Class ClassroomCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClassroomCrudController extends CrudController
{

    use CreateOperation {
        store as traitStore;
    }

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
        CRUD::setModel(\App\Models\Classroom::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/classroom');
        CRUD::setEntityNameStrings('classroom', 'classrooms');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.
       

        CRUD::addColumn([
            'label'     => 'Class',
            'type'      => 'text',
            'name'      => 'name',
        ]);

        CRUD::addColumn([
            'label'     => 'Capacity',
            'type'      => 'text',
            'name'      => 'capacity',
        ]);

        CRUD::addColumn([
            'label'     => 'Teacher', // Table column heading
            'type'      => 'checklist',
            'name'      => 'teacher_id', // the column that contains the ID of that connected entity;
            'entity'    => 'teacher', // the method that defines the relationship in your Model
            'attribute' => 'full_name', // foreign key attribute that is shown to user
            'model'     => "App\Models\Teacher", // foreign key model 
        ]);

        // CRUD::addColumn([
        //     'label'     => 'Schedule',
        //     'type'      => 'json',
        //     'name'      => 'schedule',
        // ]);

        CRUD::addColumn([
            'label' => 'Schedule',
            'type'  => 'timetable', // this matches the Blade file name
            'name'  => 'schedule',
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
        CRUD::setValidation(ClassroomRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::field([
            'label'     => 'Teacher', // Table column heading
            'type'      => 'select',
            'name'      => 'teacher_id', // the column that contains the ID of that connected entity;

            'entity'    => 'teacher', // the method that defines the relationship in your Model
            'attribute' => 'first_name', // foreign key attribute that is shown to user
            
            'model'     => "App\Models\Teacher", // foreign key model
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */


        //  $classroom = $this->crud->entry;
        //  event(new ClassroomCreated($classroom));

    }


    public function store()
    {
        $response = $this->traitStore(); // saves the classroom
        $classroom = $this->crud->entry; // now it's available
        event(new ClassroomCreated($classroom)); // dispatch event with model

        return $response;
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
