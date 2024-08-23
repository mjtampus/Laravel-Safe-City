<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <title>Admin Dashboard</title>
</head>
<body>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="container">
    <h1 style="color: #17a2b8;">USERS</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <div class="table-responsive">
                    <table class="table user-list table-bordered">
                        <thead>
                            <tr>
                                <th><span style="color: #17a2b8;">Name</span></th>
                                <th><span style="color: #17a2b8;">Email</span></th>
                                <th class="text-center"><span style="color: #17a2b8;">Role</span></th>
                                <th><span style="color: #17a2b8;">PhoneNumber</span></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                @if($user->matchesSearch(request('search')))
                                    <tr>
                                        <td>
                                            {{ $user->name }}
                                            <span class="user-subhead" style="color: #6c757d;">{{$user->role}}</span>
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td class="text-center">
                                            <span class="label label-default" style="background-color: #6c757d;">{{$user->role}}</span>
                                        </td>
                                        <td>
                                            {{$user->phone}}
                                        </td>
                                        <td style="width: 20%;">
                                            <form action="{{ route('admin.updateRole') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <label for="role"></label>
                                                <select name="role" id="role" required class="form-control">
                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <!-- Add other roles as needed -->
                                                </select>
                                                <button type="submit" class="btn btn-primary" style="margin-top: 5px;">Update Role</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($admins) && count($admins) > 0)
    <div class="container">
        <h1 style="color: #17a2b8;">ADMINS</h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <div class="table-responsive">
                        <table class="table user-list table-bordered">
                            <thead>
                                <tr>
                                    <th><span style="color: #17a2b8;">Name</span></th>
                                    <th><span style="color: #17a2b8;">Email</span></th>
                                    <th class="text-center"><span style="color: #17a2b8;">Role</span></th>
                                    <th><span style="color: #17a2b8;">PhoneNumber</span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>
                                            {{ $admin->name }}
                                            <span class="user-subhead" style="color: #28a745;">{{$admin->role}}</span>
                                        </td>
                                        <td>
                                            {{ $admin->email }}
                                        </td>
                                        <td class="text-center">
                                            <span class="label label-success" style="background-color: #28a745;">{{$admin->role}}</span>
                                        </td>
                                        <td>
                                            {{$admin->phone}}
                                        </td>
                                        <td style="width: 20%;">
                                            <!-- You can add actions for admins if needed -->
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
@else
    <p style="color: #6c757d;">No admins found.</p>
@endif
<div class="container mt-4">
        <a href="{{ url('admin/dashboard') }}" class="btn btn-primary" style="background-color: #007bff;">Go Back to Dashboard</a>
    </div>
<style>
.user-list tbody td > img {
    position: relative;
	max-width: 50px;
	float: left;
	margin-right: 15px;
}
.user-list tbody td .user-link {
	display: block;
	font-size: 1.25em;
	padding-top: 3px;
	margin-left: 60px;
}
.user-list tbody td .user-subhead {
	font-size: 0.875em;
	font-style: italic;
}


.table-bordered th, .table-bordered td {
    border: 1px solid #343a40 !important; /* Dark border color */
}

.table-bordered thead th {
    background-color: #343a40 !important; /* Dark background color */
    color: #fff !important; /* White text color */
}

.table tbody > tr > td {
    color: #212529; /* Dark text color */
}

.table tbody > tr > td, .table tbody > tr > th {
    border-top: 1px solid #495057; /* Dark border color */
}

.table-hover > tbody > tr:hover > td,
.table-hover > tbody > tr:hover > th {
	background-color: #495057; /* Dark background color on hover */
}

.table-products .name, .table-products .price, .table-products .warranty {
    color: #212529; /* Dark text color */
}
.btn-primary {
            color: #fff !important; /* White text color */
        }

        .btn-primary:hover {
            background-color: #0056b3 !important; /* Darker background color on hover */
        }
</style>
</body>
</html>
