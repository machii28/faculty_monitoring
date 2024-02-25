@extends(backpack_view('blank'))

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none">
        <h2>
            <span class="text-capitalize mb-0">Set {{ $facultyName }} Schedule</span>
        </h2>
    </section>
@endsection

@section('content')
    <div class="container-fluid animated fadeIn">
        <div class="row table-content">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Room</th>
                                    <th>Time</th>
                                    <th>Day</th>
                                    <th>Semester</th>
                                    <th>Year Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{ $schedules }}

                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <th>{{ $schedule->subject->name . '-' . $schedule->subject->code }}</th>
                                        <th>{{ $schedule->room->room_number }}</th>
                                        <th>{{ $schedule->start_time . ' - ' . $schedule->end_time }}</th>
                                        <th>{{ $schedule->day }}</th>
                                        <th>{{ $schedule->semester }}</th>
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
