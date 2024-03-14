<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div style="width: 100%; height: 100%; margin: 0; padding: 0; background-color: #fff;">
    <table>
        <thead>
        <tr>
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
            <tr>
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
</body>
</html>
