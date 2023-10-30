{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Faculties" icon="la la-chalkboard-teacher" :link="backpack_url('faculty')" />

<x-backpack::menu-dropdown title="Settings" icon="la la-gear">
    <x-backpack::menu-item title="Rooms" icon="la la-building" :link="backpack_url('room')" />
    <x-backpack::menu-item title="Subjects" icon="la la-book" :link="backpack_url('subject')" />
    <x-backpack::menu-item title="Schedules" icon="la la-calendar-alt" :link="backpack_url('schedule')" />
</x-backpack::menu-dropdown>
