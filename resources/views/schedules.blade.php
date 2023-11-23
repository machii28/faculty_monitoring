<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xltext-gray-800 leading-tight">
            {{ __('Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-800 text-white">
                        <tr class="text-center">
                            <th class="px-4 py-2">Subject</th>
                            <th class="px-4 py-2">Room</th>
                            <th class="px-4 py-2">Time</th>
                            <th class="px-4 py-2">Day</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($schedules as $schedule)
                            <tr class="text-center">
                                <td class="px-4 py-2">{{ $schedule->subject->name }}</td>
                                <td class="px-4 py-2">{{ $schedule->room->room_number }} - {{ $schedule->room->building_number }}</td>
                                <td class="px-4 py-2">{{ $schedule->time }}</td>
                                <td class="px-4 py-2">{{ $schedule->day }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
