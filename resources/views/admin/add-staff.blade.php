<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>

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
                    <h2>Add New Staff</h2>
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Staff Details</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.add-staff') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"  >
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"  >
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"  >
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"  >
                                </div>

                                <div class="form-group">
                                    <label for="profile_image">profile_image</label>
                                    <input type="file" class="form-control" name="profile_image" id="profile_image" accept="image/*">
                                </div>

                                <button type="submit" class="btn btn-primary">Add Staff</button>
                            </form>
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
