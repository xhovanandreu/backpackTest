<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('tag', 'TagCrudController');
    Route::crud('article', 'ArticleCrudController');
    Route::crud('student', 'StudentCrudController');
    Route::crud('classroom', 'ClassroomCrudController');
    Route::crud('teacher', 'TeacherCrudController');
    Route::crud('subject', 'SubjectCrudController');
    Route::crud('enrollment', 'EnrollmentCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
