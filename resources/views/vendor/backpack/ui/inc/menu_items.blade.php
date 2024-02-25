{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Subjects" icon="la la-book" :link="backpack_url('subject')" />
<x-backpack::menu-item title="Rooms" icon="la la-building" :link="backpack_url('room')" />
<x-backpack::menu-item title="Attendance" icon="la la-calendar-check" :link="backpack_url('booking')" />
<x-backpack::menu-item title="Schedules" icon="la la-calendar" :link="backpack_url('schedule')" />
