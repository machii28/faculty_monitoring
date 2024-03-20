@extends(backpack_view('blank'))

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none">
        <h2>
            <span class="text-capitalize mb-0">{{ $facultyName }} Schedule</span>
        </h2>
    </section>
@endsection

@section('content')
    <div class="container-fluid animated fadeIn">
        <!--        <a href="{{ route('schedule.create', ['source' => 'view_schedule_operation', 'user_id' => $userId]) }}" class="btn btn-sm btn-success text-white mb-3">Add Schedule</a>-->
        <div class="dropdown mb-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="semesterDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                Select Semester
            </button>
            <ul class="dropdown-menu" aria-labelledby="semesterDropdown">
                <!-- Semester items will be loaded dynamically here -->
                <li>
                    <a href="{{ route('faculty.setSchedule', ['userId' => $userId, 'semester' => '1st Semester']) }}"
                       class="dropdown-item">1st Semester</a>
                </li>
                <li>
                    <a href="{{ route('faculty.setSchedule', ['userId' => $userId, 'semester' => '2nd Semester']) }}"
                       class="dropdown-item">2nd Semester</a>
                </li>
            </ul>
        </div>

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
                                <th>Year Level</th>
                                <th>Remarks</th>
                                <!--                                 <th>Action</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <th>{{ $schedule->subject->name . '-' . $schedule->subject->code }}</th>
                                    <th>{{ $schedule->room->room_number }}</th>
                                    <th>{{ $schedule->start_time . ' - ' . $schedule->end_time }}</th>
                                    <th>{{ $schedule->day }}</th>
                                    <th>{{ $schedule->year }}</th>
                                    <th>
                                        @php
                                            $startDate = now()->startOfWeek();
                                            $endDate = now()->endOfWeek();

                                            $leaveRequest = \App\Models\LeaveRequest::whereBetween('date', [$startDate, $endDate])
                                                ->orWhereBetween('date', [$startDate, $endDate])
                                                ->orWhere(function($query) use ($startDate, $endDate) {
                                                    $query->where('date', '<', $startDate)
                                                        ->where('date', '>', $endDate);
                                                    })
                                                ->where('schedule_id', $schedule->id)
                                                ->pluck('schedule_id');
                                        @endphp

                                        @if (in_array($schedule->id, $leaveRequest->toArray()))
                                            <span>Leave: {{ $leaveRequest->reason }}</span>
                                        @endif
                                    </th>
                                    <!-- <th>
                                            <a href="{{ route('schedule.edit', ['id' => $schedule->id, 'source' => 'view_schedule_operation']) }}" class="btn btn-sm btn-success text-white">Edit</a>
                                            <button class="btn btn-sm btn-danger text-white">Delete</button>
                                        </th> -->
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
