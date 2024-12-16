<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bg-gray {
            background-color: #007bff;
            height: 100vh; 
        }

        .text-white {
            color: #ffffff;
        }

        .list-unstyled {
            padding-left: 0;
        }

        .list-unstyled li {
            margin-bottom: 20px;
        }

        .list-unstyled a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
        }

        .list-unstyled a:hover {
            color: #007bff; 
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .card-body {
            background-color: #ffffff;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .staff-profile_image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="bg-gray p-4">
                    <h4 class="text-white">Staff Management</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('admin.dashboard') }}" class="text-white">Dashboard</a></li>
                        <li><a href="{{ route('admin.staff-list') }}" class="text-white">Staff List</a></li>
                        <li><a href="{{ route('logout') }}" class="text-white">Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="p-4">
                    <h2>Staff List</h2>
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Staff Members</h5>
                            <a href="{{ route('admin.add-staff') }}" class="btn btn-primary float-right">Add Staff</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>profile_image</th>
                                        <th>Clock-in</th>
                                        <th>Clock-out</th>
                                        <th>Total Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staff as $member)
                                        <tr>
                                            <td>{{ $member->first_name }}</td>
                                            <td>{{ $member->last_name }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td>
                                                @if ($member->profile_image)
                                                <img src="{{ asset('storage/photos/' . $member->profile_image) }}" class="staff-profile_image" alt="Staff profile image">
                                                @else
                                                   <pre>      -  </pre>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($member->timesheets as $timesheet)
                                                    <div>{{ $timesheet->clock_in_time }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($member->timesheets as $timesheet)
                                                    <div>{{ $timesheet->clock_out_time }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($member->timesheets as $timesheet)
                                                    <div>{{ $timesheet->total_time }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.edit-staff', $member->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
