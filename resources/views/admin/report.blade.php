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
                        <form action="{{ route('page.report.index') }}" method="GET ">
                            <div class="form-group d-flex align-items-center">
                                <label for="report_period" class="mr-3">Select Period:</label>
                                <select id="report_period" name="report_period" class="form-control mr-3">
                                    <option @if(request()->report_period === 'daily') selected @endif  value="daily">Daily</option>
                                    <option @if(request()->report_period === 'weekly') selected @endif value="weekly">Weekly</option>
                                    <option @if(request()->report_period === 'monthly') selected @endif value="monthly">Monthly</option>
                                    <option @if(request()->report_period === 'yearly') selected @endif value="yearly">Yearly</option>
                                </select>

                                <!-- Button for triggering report generation -->
                                <button id="generate_report" class="btn btn-sm btn-primary">Generate</button>
                            </div>
                        </form>
                        <!-- Dropdown for selecting reporting period -->

                        <a href="{{ route('page.report.print') }}" class="btn btn-sm btn-success text-white">Print</a>
                        <!-- Print button -->

                        <!-- Table for displaying report -->
                        <table class="table table-striped">
                            <thead>
                            <tr class="text-center">
                                <th>Room</th>
                                <th>Building</th>
                                <th>Total Number of Seconds</th>
                                <th>Total Number of Minutes</th>
                                <th>Total Number of Hours</th>
                                <th>Total Number of Attendance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roomStats as $roomStat)
                                <tr class="text-center">
                                    <th>{{ $roomStat->room_name }}</th>
                                    <th>{{ $roomStat->building }}</th>
                                    <th>{{ $roomStat->total_seconds }}</th>
                                    <th>{{ $roomStat->total_minutes }}</th>
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
