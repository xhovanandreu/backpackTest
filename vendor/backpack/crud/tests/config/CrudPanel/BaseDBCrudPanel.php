<?php

namespace Backpack\CRUD\Tests\Config\CrudPanel;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class BaseDBCrudPanel extends BaseCrudPanel
{
    use RefreshDatabase;

    /**
     * @var CrudPanel
     */
    protected $crudPanel;

    protected $model;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // call migrations specific to our tests
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__.'/../../config/database/migrations'),
        ]);

        $this->seed('Backpack\CRUD\Tests\config\database\seeds\UsersRolesTableSeeder');
        $this->seed('Backpack\CRUD\Tests\config\database\seeds\UsersTableSeeder');
        $this->seed('Backpack\CRUD\Tests\config\database\seeds\ArticlesTableSeeder');
        $this->seed('Backpack\CRUD\Tests\config\database\seeds\MorphableSeeders');
    }

    /**
     * Assert that the attributes of a model entry are equal to the expected array of attributes.
     *
     * @param  array  $expected  attributes
     * @param  \Illuminate\Database\Eloquent\Model  $actual  model
     */
    protected function assertEntryEquals($expected, $actual)
    {
        foreach ($expected as $key => $value) {
            if (is_array($value)) {
                $this->assertEquals(count($value), $actual->{$key}->count());
            } else {
                $this->assertEquals($value, $actual->{$key});
            }
        }

        $this->assertNotNull($actual->created_at);
        $this->assertNotNull($actual->updated_at);
    }
}
