<!-- resources/views/reports/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
    <div class="absolute top-0 end-0 p-3">
    <a href="{{ url('/dashboard') }}" class="btn-like">Go to Dashboard</a>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</div>
    <style>
        
    body {
        margin: 0;
        padding: 0;
        background-color:#79497D;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: 'Your Font Name', sans-serif;
    }

    .container {
        margin-top: 20px;
    }

    .card {
       
        background-color: rgba(255, 255, 255, 0.8); /* Use an RGBA color with reduced alpha for transparency */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card-img-top {
        max-height: 500px;
        object-fit: cover;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #007bff; /* Bootstrap primary color */
    }

    .card-text {
        color: black;
    }

    .btn-danger {
        background-color: #dc3545; /* Bootstrap danger color */
        border-color: #dc3545;
    }

    h1 {
        font-size: 2rem;
        color: black;
/* Will override color (regardless of order) */
        -webkit-text-stroke-width: 1px;
        -webkit-text-stroke-color: black;
    }
    .btn-like {
        display: inline-block;
        padding: 6px 12px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #673ab7; /* Bootstrap primary color */
        border: 1px solid #007bff;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-like:hover {
        background-color: #e6bbf2; /* Darker shade on hover */
        border-color: #0056b3;
        text-decoration: none;
    }
    </style>
    </head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <h1 style="color:#7ff263; ">Confirmed Reports</h1>
            @if ($confirmedReports->isEmpty())
                    <p>You have not confirmed any reports.</p>
                @else
                @foreach ($confirmedReports as $report)
                <div class="card mb-3">
                    <img class="card-img-top" src="{{ $report->image_url }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Status: Confirmed</h5>
                        <p class="card-text">{{ $report->name }} - Type of Incident</p>
                        <p class="card-text">{{ $report->description }} </p>
                        <p class="card-text">{{ $report->user->email }} - Reported by</p>
                        
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            <div class="col-md-6">
            <h1 style="color:yellow;">Pending Reports</h1>
            @if ($pendingReports->isEmpty())
                    <p>You have no pending reports.</p>
                @else
                @foreach ($pendingReports as $report)
                <div class="card mb-3">
                    <img class="card-img-top" src="{{ $report->image_url }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Status: Pending</h5>
                        <p class="card-text">{{ $report->name }} - Type of Incident</p>
                        <p class="card-text">{{ $report->description }}</p>
                        <p class="card-text">{{ $report->user->email }} - Reported by</p>
                        <form method="post" action="{{ route('report.deleteReport', $report->id) }}" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-primary" onclick="confirmDelete()">Cancel Report</button>
                        </form>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</body>
</html>
<script>

function confirmDelete() {
        Swal.fire({
            title: 'Are you sure, you want to cancel it?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user clicks "Yes," submit the form
                document.querySelector('form').submit();
            }
        });
    }
</script>
