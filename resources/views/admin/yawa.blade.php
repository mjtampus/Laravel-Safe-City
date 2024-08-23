<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Side Navigation Bar in HTML CSS JavaScript</title>
    <link rel="stylesheet" href="/css/dashboard-container.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        </i>Welcome Admin!
      </div>

      <div class="navbar_content">
        <i class="bi bi-grid"></i>
        <i class='bx bx-sun' id="darkLight"></i>
      </div>
    </nav>

    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div  href="#" class="nav_link submenu_item" id="home">
              <span class="navlink_icon">
                <i class="bx bx-home-alt"></i>
              </span>
              <span class="navlink">Home</span>
            </div>
          </li>
          <!-- end -->

          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
              <i class='bx bx-star'></i>
              </span>
              <span class="navlink">Users Feedback</span>
            </div>
          </li>
          <!-- end -->
        </ul>

        <ul class="menu_items">
          <div class="menu_title menu_editor"></div>
          <!-- duplicate these li tag if you want to add or remove navlink only -->
          <!-- Start -->
          <li class="item">
            <a href="#" class="nav_link" id="make-announcement">
              <span class="navlink_icon">
                <i class="bx bxs-megaphone"></i>
              </span>
              <span class="navlink">Make Announcement</span>
            </a>
          </li>
          <!-- End -->

          <li class="item">
            <a href="#" class="nav_link" id="reports">
              <span class="navlink_icon">
                <i class="bx bxs-report"></i>
              </span>
              <span class="navlink">Reports</span>
            </a>
          </li>
          <li class="item">
            <a href="#" class="nav_link" id="manage-users">
              <span class="navlink_icon">
                <i class="bx bxs-user-detail"></i>
              </span>
              <span class="navlink">Manage Users</span>
            </a>
          </li>
          <li class="item">
            <a href="{{ route('logout') }}" class="nav_link">
              <span class="navlink_icon">
               <i class='bx bx-log-out'></i>
              </span>
              <span class="navlink">Log Out</span>
            </a>
          </li>
        </ul>

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Lock</span>
            <i class='bx bx-lock-open' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Unlock</span>
            <i class='bx bx-lock' ></i>
          </div>
        </div>
      </div>
    </nav>
    <!-- Main container -->
    <div class="main-container">
      <div class="subview" id="subview1">
        @include('admin/adminDashboard');
      </div>
      <div class="subview" id="subview2" style="display: none">
        @include('admin/createAnnouncement');
      </div>
      <div class="subview" id="subview3" style="display: none">
      <h2>Admin - Manage Accident Reports</h2>
<div id="map" style="height: 400px;"></div>

<script src="https://maps.googleapis.com/maps/api/js?key= API KEY NINYU AREEEEEEEEE &libraries=places"></script>
    <!-- Include mapScript.js -->
    <script src="{{ asset('js/mapScript.js') }}" defer></script>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($confirmedReports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->latitude }}, {{ $report->longitude }}</td>
                    <td>{{ $report->description }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.revertReportStatus', $report->id) }}" style="display:inline;">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-warning">Revert to Pending</button>
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
                <th>Action</th>
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

<script>
    function viewMapLocation(latitude, longitude) {
        // Center the map on the specified location
        map.setCenter({ lat: latitude, lng: longitude });
        map.setZoom(16); // Set the desired zoom level
    }
</script>
    </div>
      <div class="subview" id="subview4" style="display: none">
        @include('admin/manageUsers');
      </div>
    </div>
    <!-- JavaScript -->
<script>
  const body = document.querySelector("body");
  const darkLight = document.querySelector("#darkLight");
  const sidebar = document.querySelector(".sidebar");
  const submenuItems = document.querySelectorAll(".submenu_item");
  const sidebarOpen = document.querySelector("#sidebarOpen");
  const sidebarClose = document.querySelector(".collapse_sidebar");
  const sidebarExpand = document.querySelector(".expand_sidebar");
  const hello = () => console.log('hello');
  sidebarOpen.addEventListener("click", () => sidebar.classList.toggle("close"));

  sidebarClose.addEventListener("click", () => {
    sidebar.classList.add("close", "hoverable");
  });
  sidebarExpand.addEventListener("click", () => {
    sidebar.classList.remove("close", "hoverable");
  });

  sidebar.addEventListener("mouseenter", () => {
    if (sidebar.classList.contains("hoverable")) {
      sidebar.classList.remove("close");
    }
  });
  sidebar.addEventListener("mouseleave", () => {
    if (sidebar.classList.contains("hoverable")) {
      sidebar.classList.add("close");
    }
  });

  darkLight.addEventListener("click", () => {
    body.classList.toggle("dark");
    if (body.classList.contains("dark")) {
      document.setI
      darkLight.classList.replace("bx-sun", "bx-moon");
    } else {
      darkLight.classList.replace("bx-moon", "bx-sun");
    }
  });

  submenuItems.forEach((item, index) => {
    item.addEventListener("click", () => {
      item.classList.toggle("show_submenu");
      submenuItems.forEach((item2, index2) => {
        if (index !== index2) {
          item2.classList.remove("show_submenu");
        }
      });
    });
  });

  if (window.innerWidth < 768) {
    sidebar.classList.add("close");
  } else {
    sidebar.classList.remove("close");
  }

  const subviews = document.getElementsByClassName('subview');

  const showElement = (subviewId) => {
    for (const subview of subviews) {
      subview.style.display = 'none';
    }

    const selectedElement = document.getElementById(subviewId);
    selectedElement.style.display = 'block';
  };

  document.getElementById('home').addEventListener('click', () => {
    showElement('subview1');
  });

  document.getElementById('make-announcement').addEventListener('click', () => {
    showElement('subview2');
  });

  document.getElementById('reports').addEventListener('click', () => {
    showElement('subview3');
  });

  document.getElementById('manage-users').addEventListener('click', () => {
    showElement('subview4');
  });

</script>
  </body>
</html>