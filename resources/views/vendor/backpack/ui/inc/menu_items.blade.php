{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
<x-backpack::menu-item title="Tags" icon="la la-question" :link="backpack_url('tag')" />
<x-backpack::menu-item title="Articles" icon="la la-question" :link="backpack_url('article')" />
<x-backpack::menu-item title="Students" icon="la la-question" :link="backpack_url('student')" />
<x-backpack::menu-item title="Classrooms" icon="la la-question" :link="backpack_url('classroom')" />
<x-backpack::menu-item title="Teachers" icon="la la-question" :link="backpack_url('teacher')" />
<x-backpack::menu-item title="Subjects" icon="la la-question" :link="backpack_url('subject')" />
<x-backpack::menu-item title="Enrollments" icon="la la-question" :link="backpack_url('enrollment')" />