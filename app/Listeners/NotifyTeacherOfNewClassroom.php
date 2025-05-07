<?php

namespace App\Listeners;

use App\Events\ClassroomCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewClassroomNotification;
use Illuminate\Support\Facades\Mail;

class NotifyTeacherOfNewClassroom
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassroomCreated $event): void
    {
        $teacher = $event->classroom->teacher;
        if ($teacher && $teacher->email) {
            Mail::to($teacher->email)->send(new NewClassroomNotification($event->classroom));
        }
    }

}
