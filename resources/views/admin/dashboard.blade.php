

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="/css/dashboard-container.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  </head>
  <body>
    <nav class="sidebar">
      <a href="#" class="logo">SAFE CITY</a>
      <div class="menu-content">
        <ul class="menu-items">
          <li class="item">
            <a  href="{{route('admin.dashboard')}}" class="nav_link submenu_item" id="home">
              <span class="navlink_icon">
                <i class="bx bx-home-alt"></i>
              </span>
              <span class="navlink">Home</span>
            </a>
          </li>
          <li class="item">
          <a href="{{route('announcements.create')}}" class="nav_link" id="make-announcement">
              <span class="navlink_icon">
                <i class="bx bxs-megaphone"></i>
              </span>
              <span class="navlink">Make Announcement</span>
            </a>
          <li class="item">
            <a href="{{route('admin.accident_reports')}}" class="nav_link" id="reports">
              <span class="navlink_icon">
                <i class="bx bxs-report"></i>
              </span>
              <span class="navlink">Reports</span>
            </a>
          </li>
          <li class="item">
            <div class="submenu-item">
              <span>Mannage Users</span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>
            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                Manage Users
              </div>
              <li class="item">
                <a href="{{url('admin/manage-roles')}}">Manage Roles</a>
              </li>
            </ul>
          </li>
          
          <li class="item">
            <a href="{{route('logout')}}" class="nav_link" id="reports">
              <span class="navlink_icon">
                <i class="bx bxs-report"></i>
              </span>
              <span class="navlink">logout</span>
            </a>
          </li>

        </ul>
      </div>
    </nav>
    <nav class="navbar">
      <i class="fa-solid fa-bars" id="sidebar-close"></i>
    </nav>
    <main class="main">
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

    </main>
    <script src="script.js"></script>
  </body>
</html>

<script>
 const sidebar = document.querySelector(".sidebar");
const sidebarClose = document.querySelector("#sidebar-close");
const menu = document.querySelector(".menu-content");
const menuItems = document.querySelectorAll(".submenu-item");
const subMenuTitles = document.querySelectorAll(".submenu .menu-title");
sidebarClose.addEventListener("click", () => sidebar.classList.toggle("close"));
menuItems.forEach((item, index) => {
  item.addEventListener("click", () => {
    menu.classList.add("submenu-active");
    item.classList.add("show-submenu");
    menuItems.forEach((item2, index2) => {
      if (index !== index2) {
        item2.classList.remove("show-submenu");
      }
    });
  });
});
subMenuTitles.forEach((title) => {
  title.addEventListener("click", () => {
    menu.classList.remove("submenu-active");
  });
});
</script>