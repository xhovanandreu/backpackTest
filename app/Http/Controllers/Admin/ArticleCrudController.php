<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article');
        CRUD::setEntityNameStrings('article', 'articles');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        CRUD::column('title')->label('Title');

        CRUD::addColumn([
            'type' => 'select_multiple',
            'label' => 'Tags for articles',
            'name' => 'tags', // the relationship method in the Article model
            'entity' => 'tags', // the relationship name in your Article Model
            'attribute' => 'name', // attribute shown for each tag
            'model' => "App\Models\Tag",
        ]);


        // CRUD::filter('title')
        // ->type('text')
        // ->label('The title')
        // ->whenActive(function($value) {
        //     CRUD::addClause('where', 'title', 'LIKE', '%'.$value.'%');
        // })->else(function() {
        //     // nada
        // });

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
        CRUD::setValidation(ArticleRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        CRUD::addField([
            'name' => 'title',
            'type' => 'text',
            'label' => 'Title',
        ]);
    
        CRUD::addField([
            'label'     => "Tags",
            'type'      => 'select_multiple',
            'name'      => 'tags', // the method on the model
            'entity'    => 'tags', // the method on the model
            'model'     => "App\Models\Tag", // related model
            'attribute' => 'name', // displayed value
            'pivot'     => true, // pivot table handling
        ]);

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


    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */

    protected function  setupShowOperation(){
        // MAYBE: do stuff before the autosetup

        // automatically add the columns
        $this->autoSetupShowOperation();

        // MAYBE: do stuff after the autosetup

        // for example, let's add some new columns
        CRUD::column([
            'name'  => 'my_custom_html',
            'label' => 'Custom HTML',
            'type'  => 'custom_html',
            'value' => '<span class="text-danger">Something</span><h1>This can be a header here</h1>',
        ]);
       
        // this is for cutom html
        // CRUD::column([
        //     'name'  => 'tags_list_with_links',
        //     'type'  => 'custom_html',
        //     'label' => 'Tags',
        //     'value' => function( $entry){
        //         return $entry->getTagsListWithLinks();
        //     },
        // ]);


        // this is to attach a simple link
        // CRUD::column('tags')->label('tags')
        // ->type('select_multiple')
        // ->entity('tags')
        // ->attribute('name')
        // ->model(Tag::class)
        // ->linkTo(fn($entry) => backpack_url("tag/{$entry->id}/show"));

        CRUD::column('tags')->linkTo('tag.show');

        
        // or maybe remove a column
        CRUD::column('text')->remove();
    }
}
