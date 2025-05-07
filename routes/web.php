<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TeacherMail;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/testroute', function() {

    // The email sending is done using the to method on the Mail facade
    // Mail::to('testreceiver@gmail.com')->send(new TeacherMail('Funny Coder'));

    Mail::to('testreceiver@gmail.com')
    ->queue(new TeacherMail('Funny Coder'));
});