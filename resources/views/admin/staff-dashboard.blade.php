<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2>Welcome to Your Dashboard, {{ Auth::user()->first_name }}!</h2>
            <p>Manage your activities and view your stats below.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5>Your Stats</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center border-info">
                            <div class="card-body">
                                <h6 class="card-title">Total Staff Members</h6>
                                <p class="card-text display-4">{{ $staffCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button id="clockButton" class="btn btn-success">Clock In</button>
        </div>

        <div id="ajaxSuccessMessage" class="alert alert-success mt-4 d-none">
            Action recorded successfully!
        </div>

        <div class="text-center mt-4">
            <form action="{{ route('logout') }}" method="get">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function() {
            let isClockedIn = false;

            $('#clockButton').on('click', function() {
                if (!isClockedIn) {
                    $.ajax({
                        url: '{{ route("staff.clock_in") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#ajaxSuccessMessage').text('Clock In recorded successfully!').removeClass('d-none');
                                $('#clockButton').text('Clock Out').removeClass('btn-success').addClass('btn-danger');
                                isClockedIn = true;
                            }
                        },
                        error: function() {
                            alert('There was an error processing your request. Please try again.');
                        }
                    });
                } else {
                    $.ajax({
                        url: '{{ route("staff.clock_out") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#ajaxSuccessMessage').text('Clock Out recorded successfully! Total time: ' + response.total_time).removeClass('d-none');
                                $('#clockButton').text('Clock In').removeClass('btn-danger').addClass('btn-success');
                                isClockedIn = false;
                            }
                        },
                        error: function() {
                            alert('There was an error processing your request. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
