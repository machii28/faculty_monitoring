@extends(backpack_view('blank'))

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none">
        <h2>
            <span class="text-capitalize mb-0">Create Schedule</span>
        </h2>
    </section>
@endsection

@section('content')
    <div class="container-fluid animated fadeIn">
        <div class="row table-content">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('schedule.saveSchedule') }}">

                            <div class="mb-3">
                                <label for="subjectId" class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                <select name="subjectId" id="subjectId" class="form-control">
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}"> <p class="fw-bold">{{ $subject->code }}</p> | {{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="roomId" class="form-label fw-bold">Room <span class="text-danger">*</span></label>
                                <select name="roomId" id="roomId" class="form-control">
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}"> <p class="fw-bold">{{ $room->room_number }}</p> | {{ $room->building_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="year_level" class="form-label fw-bold">Year Level <span class="text-danger">*</span></label>
                                <select name="year_level" id="year_level" class="form-control">
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="year_level" class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                                <select name="year_level" id="year_level" class="form-control">
                                    <option value="1st Semester">1st Semester</option>
                                    <option value="2nd Semester">2nd Semester</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="start_time" class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" id="start_time" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="end_time" class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" id="end_time" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="day" class="form-label fw-bold">Day <span class="text-danger">*</span></label>
                                <select name="day" id="day" class="form-control">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
