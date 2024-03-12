<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .scene {
            width: 150px;
            height: 150px;
            border: 1px solid #CCC;
            margin: 20px auto;
            perspective: 300px;
        }

        .cube {
            width: 150px;
            height: 150px;
            position: relative;
            transform-style: preserve-3d;
            transform: translateZ(-75px);
        }

        .cube__face {
            position: absolute;
            width: 150px;
            height: 150px;
            border: 2px solid black;
            font-size: 14px;
            font-weight: bold;
            color: white;
            text-align: center;
        }

        .cube__face--available {
            background: hsla(120, 100%, 50%, 0.7);
            color: black;
        }

        .cube__face--occupied {
            background: hsla(0, 100%, 50%, 0.4);
            color: white;
        }

        .cube__face--front {
            transform: rotateY(0deg) translateZ(75px);
        }

        .cube__face--right {
            transform: rotateY(90deg) translateZ(75px);
        }

        .cube__face--back {
            transform: rotateY(180deg) translateZ(75px);
        }

        .cube__face--left {
            transform: rotateY(-90deg) translateZ(75px);
        }

        .cube__face--top {
            transform: rotateX(90deg) translateZ(75px);
        }

        .cube__face--bottom {
            transform: rotateX(-90deg) translateZ(75px);
        }

        .cube.is-backface-hidden .cube__face {
            backface-visibility: hidden;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @php
                    $rooms = \App\Models\Room::get();
                @endphp

                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-800 text-white">
                        <tr class="text-center">
                            <th class="px-4 py-2">Room</th>
                            <th class="px-4 py-2">Occupant</th>
                            <th class="px-4 py-2">Occupied</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($rooms as $room)
                            @php
                                $booking = \App\Models\Booking::where('room_id', $room->id)
                                    ->where('booking_date', now()->toDateString())
                                    ->first();
                            @endphp

                            <tr class="text-center">
                                <td class="px-4 py-2">{{ $room->room_number }} - {{ $room->building_number }}</td>
                                <td class="px-4 py-2"><span class="block">@if ($booking){{ $room->is_occupied ? $booking->user->first_name . ' ' . $booking->user->last_name : '' }}@endif</span></td>
                                <td class="px-4 py-2">
                                    @if ($room->is_occupied)
                                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Occupied</span
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-600 ring-1 ring-inset ring-green-600/10">Available</span
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
