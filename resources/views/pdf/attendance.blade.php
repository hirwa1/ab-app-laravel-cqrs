<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
</head>
<body>
    <h1>Attendance Report</h1>
    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Employee ID</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Total Hours</th>
                <th>Overtime</th>
                <th>Remarks</th>
                <th>Approved By</th>
                <th>Approved At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $row['Employee Name'] }}</td>
                    <td>{{ $row['Employee Email'] }}</td>
                    <td>{{ $row['Employee ID'] }}</td>
                    <td>{{ $row['Date'] }}</td>
                    <td>{{ $row['Time In'] }}</td>
                    <td>{{ $row['Time Out'] }}</td>
                    <td>{{ $row['Total Hours'] }}</td>
                    <td>{{ $row['Overtime'] }}</td>
                    <td>{{ $row['Remarks'] }}</td>
                    <td>{{ $row['Approved By'] }}</td>
                    <td>{{ $row['Approved At'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>