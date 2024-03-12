@extends(backpack_view('blank'))

@section('content')
<div>
    <h1 class="mb-4">Report</h1>
</div>

    <div class="container-fluid animated fadeIn">
        <div class="row table-content">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('page.report.print') }}" class="btn btn-success text-white">Print</a>

                        <table class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>Room</th>
                                    <th>Building</th>
                                    <th>Total Number of Hours</th>
                                    <th>Total Number of Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($roomStats as $roomStat)
                                <tr class="text-center">
                                    <th>{{ $roomStat->room_name }}</th>
                                    <th>{{ $roomStat->building }}</th>
                                    <th>{{ $roomStat->total_hours }}</th>
                                    <th>{{ $roomStat->total_bookings }}</th>
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
