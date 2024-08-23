<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Add these lines in your HTML file -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

  <title>Admin Dashboard</title>
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 50px;
    }

    .card {
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-body {
      text-align: center;
    }

    .card-title i {
      font-size: 24px;
      margin-right: 10px;
    }

    .card-text {
      font-size: 20px;
      font-weight: bold;
      color: #007bff;
    }

    .card-list {
      list-style: none;
      padding: 0;
    }

    .card-list li {
      border-bottom: 1px solid #ddd;
      padding: 10px;
    }

    .card-list li:last-child {
      border-bottom: none;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1 class="text-center mb-4">Admin Dashboard</h1>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fas fa-check-circle text-success"></i> Confirmed Reports
            </h5>
            <p class="card-text">{{ $confirmedReportsCount }}</p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fas fa-exclamation-circle text-warning"></i> Pending Reports
            </h5>
            <p class="card-text">{{ $pendingReportsCount }}</p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fas fa-users text-primary"></i> Total Users
            </h5>
            <p class="card-text">{{ $usersCount }}</p>
          </div>
        </div>
      </div>

      <div class="col-md-8 mb-4">
        <div class="card">
          <div class="card-body" style="height: 300px; overflow-y: auto;">
            <h5 class="card-title">
              <i class="fas fa-trophy text-warning"></i> User Leaderboard
            </h5>
            <ul class="card-list">
              @foreach ($leaderboard as $user)
              <li>
                <strong>{{ $user->name }}</strong>
                <p>Email: {{ $user->email }}</p>
                <p>Confirmed Reports: {{ $user->confirmed_reports_count }}</p>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body" style="height: 300px; overflow-y: auto;">
            <h5 class="card-title">
              <i class="fas fa-users text-primary"></i> Total Users
            </h5>
            <ul class="card-list">
              @foreach ($users as $users)
              <li>
                <strong>{{ $users->name }}</strong>
                <p>Email: {{ $users->email }}</p>
            
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
