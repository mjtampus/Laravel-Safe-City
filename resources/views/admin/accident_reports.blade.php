<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  </head>
  <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #343a40; /* Dark background color */
        color: #dee2e6; /* Light text color */
        padding: 20px;
        margin: 0;
    }

    h2, h3 {
        color: #17a2b8; /* Admin vibe theme color */
    }

    #map {
        height: 650px;
        margin-bottom: 20px;
    }

    .alert {
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #495057; /* Dark border color */
    }

    th {
        background-color: #007bff;
        color: #fff;
    }

    tbody tr:nth-child(even) {
        background-color: #495057; /* Darker background for even rows */
    }

    tbody tr:hover {
        background-color: #212529; /* Dark background on hover */
    }

    .btn {
        margin-right: 5px;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-info {
        background-color: #17a2b8; /* Admin vibe theme color */
        color: #fff;
    }

    .btn-danger {
        background-color: #dc3545; /* Red color */
        color: #fff;
    }

    .btn-warning {
        background-color: #ffc107; /* Yellow color */
        color: #212529;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .action-column {
        text-align: center;
    }

    .action-column button {
        margin: 5px;
    }

    #redirectButton {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #17a2b8; /* Admin vibe theme color */
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    #redirectButton:hover {
        background-color: #138496; /* Darker admin vibe theme color on hover */
    }
    </style>
  <body>@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <h2>Admin - Manage Accident Reports</h2>
    <a href="{{ url('/admin/dashboard') }}" id="redirectButton" class="btn btn-primary">Go to Admin Dashboard</a>
    
<div id="map" style="height: 650px;"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=  API KEY NINYU ARI SA GOOGLE MAP  &libraries=places"></script>
    <!-- Include mapScript.js -->
    <script src="{{ asset('js/mapScript.js') }}" defer></script>


<h3>Confirmed Reports</h3>
@if($confirmedReports->isEmpty())
    <p>No confirmed accident reports.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Location</th>
                <th>Description</th>
                <th>Reported By</th>
                <th>Name</th>
                <th>Submitted At</th>
                <th class="action-column">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($confirmedReports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->latitude }}, {{ $report->longitude }}</td>
                    <td>{{ $report->description }}</td>
                    <td>{{ $report->user->email }}</td>
                    <td>{{ $report->user->name }} {{ $report->user->lastname }}</td>
                    <td>{{ $report->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.revertReportStatus', $report->id) }}" style="display:inline;">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-warning">Pending</button>
                        </form>
                        
                        <form method="post" action="{{ route('admin.deleteReport', $report->id) }}" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <button type="button" class="btn btn-info" onclick="viewMapLocation({{ $report->latitude }}, {{ $report->longitude }})">
                         View Location
                        </button>
                        <!-- Add other actions/buttons as needed -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<h3>Pending Reports</h3>
@if($pendingReports->isEmpty())
    <p>No pending accident reports.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Location</th>
                <th>Description</th>
                <th>Reported By</th>
                <th>Name</th>
                <th>Submitted At</th>
                <th class="action-column">Action</th>
            </tr>
        </thead>
        <tbody>
        <script>
        var pendingReportsData = @json($pendingReports);
    </script>
            @foreach($pendingReports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->latitude }}, {{ $report->longitude }}</td>
                    <td>{{ $report->description }}</td>
                    <td>{{ $report->user->email }}</td>
                    <td>{{ $report->user->name }} {{ $report->user->lastname }}</td>
                    <td>{{ $report->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.confirmReport', $report->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>

                        <form method="post" action="{{ route('admin.deleteReport', $report->id) }}" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        <button type="button" class="btn btn-info" onclick="viewMapLocation({{ $report->latitude }}, {{ $report->longitude }})">
                         View Location
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

  </body>
</html>
<script>
    function viewMapLocation(latitude, longitude) {
        // Center the map on the specified location
        map.setCenter({ lat: latitude, lng: longitude });
        map.setZoom(16); // Set the desired zoom level
    }
</script>
 
  </body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            