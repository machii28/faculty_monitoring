@extends(backpack_view('blank'))

@php
    $rooms = \App\Models\Room::get();
@endphp

@section('content')
    <style>
        .scene {
            width: 150px;
            height: 150px;
            border: 1px solid #CCC;
            margin: 20px auto;
            perspective: 300px;
            cursor: pointer;
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
            cursor: pointer;
        }

        .cube__face--available   {
            background: hsla(152, 95%, 35%, 0.7);
            color: black;
        }
        .cube__face--occupied    {
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

        .cube:hover .custom-tooltip {
            display: block;
        }

        .custom-tooltip {
            display: none;
            position: absolute;
            background: rgb(0, 0, 0, 0.5);
            font-size: 13px;
        }
    </style>

    <div class="container-fluid" style="background: white">
        <div class="row">
            @foreach($rooms as $room)
                @php
                    $booking = \App\Models\Booking::where('room_id', $room->id)
                                    ->where('booking_date', now()->toDateString())
                                    ->first();
                @endphp

                <div class="col-lg-3 col-md-3">
                    <div class="scene" @if (!$room->is_occupied) onclick="redirect({{ $room->id }})" @endif>
                        <div class="cube">
                            <div class="cube__face cube__face--front @if($room->is_occupied) cube__face--occupied @else cube__face--available @endif">
                                <span class="d-block mt-3">Room {{ $room->room_number }}</span>
                                <span class="d-block">@if ($booking){{ $room->is_occupied ? $booking->user->full_name : '' }}@endif</span>
                                <span class="d-block mt-3">
                                    @if ($room->is_occupied)
                                        Occupied
                                    @else
                                        Available
                                    @endif
                                </span>
                                @if($booking)
                                    <div class="custom-tooltip">
                                        <span class="d-block">Occupant: {{ $booking->user->full_name }}</span>
                                        <span class="d-block">Time Occupied: {{ $booking->start_booking_time }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="cube__face cube__face--back @if($room->is_occupied) cube__face--occupied @else cube__face--available @endif"></div>
                            <div class="cube__face cube__face--right @if($room->is_occupied) cube__face--occupied @else cube__face--available @endif"></div>
                            <div class="cube__face cube__face--left @if($room->is_occupied) cube__face--occupied @else cube__face--available @endif"></div>
                            <div class="cube__face cube__face--top @if($room->is_occupied) cube__face--occupied @else cube__face--available @endif"></div>
                            <div class="cube__face cube__face--bottom @if($room->is_occupied) cube__face--occupied @else cube__face--available @endif"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function redirect(room_id) {
            window.location.href = '/admin/booking?room_id=' + room_id;
        }
    </script>
@endsection
