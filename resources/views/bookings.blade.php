<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xltext-gray-800 leading-tight">
            {{ __('Attendance') }}
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
                            <th class="px-4 py-2">Day</th>
                            <th class="px-4 py-2">Time In</th>
                            <th class="px-4 py-2">Time Out</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($bookings as $booking)
                            <tr class="text-center">
                                <td class="px-4 py-2">{{ $booking->subject->name }}</td>
                                <td class="px-4 py-2">{{ $booking->room->room_number }} - {{ $booking->room->building_number }}</td>
                                <td class="px-4 py-2">{{ $booking->booking_date }}</td>
                                <td class="px-4 py-2">{{ $booking->start_booking_time }}</td>
                                <td class="px-4 py-2">{{ $booking->end_booking_time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
