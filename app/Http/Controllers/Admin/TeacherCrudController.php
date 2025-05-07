<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TeacherRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TeacherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TeacherCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Teacher::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/teacher');
        CRUD::setEntityNameStrings('teacher', 'teachers');
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
        CRUD::column('photo')->type('image')->disk('public');


        CRUD::column([
            'name'  => 'is_full_time',
            'label' => 'Is full time',
            'type'  => 'custom_html',

            'value' => function($entry) {
                return match($entry->is_full_time) {
                    0 => '<span class="badge bg-warning text-dark">NO</span>',
                    default => '<span class="badge bg-success">YES</span>',
                };
            },
        ]);

        CRUD::column([
            'name'  => 'email',
            'label' => 'Email',
            'type'  => 'email',
        ]);

        CRUD::column([
            'name'  => 'is_full_time',
            'label' => 'Is full time',
            'type'  => 'custom_html',

            'value' => function($entry) {
                return match($entry->is_full_time) {
                    0 => '<span class="badge bg-warning text-dark">NO</span>',
                    default => '<span class="badge bg-success">YES</span>',
                };
            },
        ]);

        CRUD::column([
            'name'  => 'full_name',
            'label' => 'Emri',
            'type'  => 'text',
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
        CRUD::setValidation(TeacherRequest::class);


        CRUD::addField([
            'name'      => 'first_name',
            'label'     => 'First Name',
            'type'      => 'text',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        CRUD::addField([
            'name'      => 'last_name',
            'label'     => 'Last Name',
            'type'      => 'text',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        CRUD::addField([
            'name'      => 'email',
            'label'     => 'Email',
            'type'      => 'email',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        CRUD::addField([
            'name'      => 'phone',
            'label'     => 'Phone',
            'type'      => 'text',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);
        CRUD::addField([
            'name'      => 'hire_date',
            'label'     => 'Hire date',
            'type'      => 'date',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        CRUD::addField([
            'name'      => 'photo',
            'label'     => 'Image',
            'type'      => 'upload',
            'withFiles' => [
                'disk' =>'public',
                'visibility' =>'public',
            ],
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        CRUD::addField([
            'name'      => 'is_full_time',
            'label'     => 'Is full time',
            'type'  => 'checkbox',
            'default' => true,
            'wrapper' => ['class' => 'form-group col-md-6']
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
