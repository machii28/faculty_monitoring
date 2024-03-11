@extends(backpack_view('blank'))

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none">
        <h1 class="mb-4">Schedule Of The Day</h1>
    </section>
@endsection

@section('content')
    @php
        $schedules = \App\Models\Schedule::with(['subject', 'room', 'user'])->where('day', now()->format('l'))->get();
    @endphp

    <div class="container-fluid animated fadeIn">
        <div class="row table-content">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Professor</th>
                                    <th>Room</th>
                                    <th>Time</th>
                                    <th>Year Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                    <tr>
                                        <th>{{ $schedule->subject->name . ' - ' . $schedule->subject->code }}</th>
                                        <th>{{ $schedule->user->full_name }}</th>
                                        <th>{{ $schedule->room->room_number }}</th>
                                        <th>{{ $schedule->start_time . ' - ' . $schedule->end_time }}</th>
                                        <th>{{ $schedule->year }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
