<!DOCTYPE html>
<html lang="en">
<head>
<script>
        window.baseUrl = "{{ asset('') }}";
 </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accident Report</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- Include the Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key= API KEY NINYU SA GOOGLE MAP &libraries=places"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap');
     .navbar .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .navbar .user-dropdown i {
        color: white;
    }

    .navbar .user-dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        border: 1px white;
        z-index: 1;
    }

    .navbar .user-dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .navbar .user-dropdown-content i {
        color: black;
    }

    .navbar .user-dropdown-content i:hover {
        color: white;
    }  

    .navbar .user-dropdown-content a:hover {
        background-color: #79497D;
        color: white;
    } 

    .navbar .user-dropdown.show .user-dropdown-content {
        display: block;
    }

    .search_bar {
    position: relative;
}

.search_bar input {
    padding-left: 40px; /* Adjust initial padding as needed */
    background-color: transparent;
}

.search_bar .bx-search {
    position: absolute;
    left: 10px; /* Adjust icon position as needed */
    top: 50%;
    transform: translateY(-50%);
    color: white; /* Adjust icon color as needed */
    font-size: 20px; /* Adjust icon size as needed */
    transition: left 0.3s ease; /* Add transition effect */
}

.search_bar input:focus + .bx-search {
    left: 15px; /* Adjust icon position when input is focused */
}
.search_bar input::placeholder {
    color: white; /* Set placeholder text color to white */
}
@media screen and (max-width: 768px) {
    .logo_text {
        display: none;
    }
    .logo_item img{
        display:none;
    }
}



</style>
</head>
<body>
      <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="images/SafeCityLogo.png" alt=""></i><span class="logo_text">SAFECITY</span>
      </div>
      <div class="search_bar">
    <input type="text" id="destination" placeholder="Enter destination" onclick="clearPlaceholder()">
    <i class="bx bx-search search-icon"></i>
      </div>
      <div class="navbar_content">
      <ul class="notification-drop">
            <li class="item">
                <i id="notif" class='bx bx-bell' aria-hidden="true"></i>
                <span class="btn__badge pulse-button" id="notif-count"></span>
                <ul id="ul_o">
                    @foreach(auth()->user()->unreadNotifications as $notification)
                        <li>
                            @if ($notification->type === 'announcement')
                                <a href="{{ url('announcements') }}">New announcement. Click to View.</a>
                            @else
                                <a href="{{ isset($notification->data['report_id']) ? route('dashboard.report', ['report' => $notification->data['report_id']]) : '#' }}">
                                    {{ $notification->data['content'] }} View Report
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>

        <div class="user-dropdown">
            <i class='bx bx-user' id="userIcon"></i>
            <div class="user-dropdown-content">
                <a href="{{route('settings.index')}}"><i class='bx bx-edit'> User Settings
                </i></a>
                <a href="{{ route('logout') }}">
                    <i class= 'bx bx-log-out'> Log out</i></a>
            </div>
        </div>

</div>
    </nav>
    <!-- sidebar -->
    <nav class="sidebar">
        <div class="menu_content">
                <ul class="menu_items">
                <div class="user-container">
                <img src="{{$user->profile_image}}" ><span class="user-name">{{ $user->name }}</span>
                </div>
                <div class="menu_title menu_dahsboard"></div>
                <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
                <!-- start -->
                <li class="item">
                    <a href="{{route('dashboard')}}" class="nav_link submenu_item">
                    <span class="navlink_icon">
                        <i class="bx bx-home-alt"></i>
                    </span>
                    <span class="navlink">Home</span>
                    </a>
                    
                    <div href="#" onclick="redirectToReportForm()" class="nav_link submenu_item">
                    <span class="navlink_icon">
                    <i class='bx bx-folder-plus' ></i>
                    </span>
                    <span class="navlink">Report Incident</span>
                    </div>
                    <a href="{{ route('reports.ReportDashboard') }}" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class='bx bxs-report'></i>
                        </span>
                            <span class="navlink">Your Reports</span>
                    </a>
                    <a href="{{ route('leaderboard.index') }}" class="nav_link submenu_item">
                     <div>
                    <span class="navlink_icon">
                    <i class='bx bx-objects-vertical-bottom'></i>
                    </span>
                    <span class="navlink">Leaderboards</span>
                    </div>
                    </a>

                    <a href="{{url('change-marker')}}" class="nav_link submenu_item">
                     <div>
                    <span class="navlink_icon">
                    <i class='bx bx-map'></i>
                    </span>
                    <span class="navlink">EditMarker</span>
                    </div>
                    </a>

                </li>

                <!-- end -->
                </ul>
                
            <!-- Sidebar Open / Close -->
            <div class="bottom_content">
            <div class="bottom expand_sidebar">
            </div>
            <div class="bottom collapse_sidebar">
            </div>
            </div>
        </div>
    </nav>
    <div class="main-container">

        <input type="hidden" id="latitude" readonly>

        <input type="hidden" id="longitude" readonly>

<div id="map-container">
<div id="floating-buttons">
    <button onclick="toggleUserLocationMarker()">
        <i class='bx bx-map'></i>
    </button>
    <button onclick="toggleRadiusCircle()">
        <i class='bx bx-map-pin'></i>
    </button>
</div>
    <div id="map"></div>
</div>
    <!-- Map container -->
 
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
 $(document).ready(function() {
            let notifCount = $("#ul_o li").length;
            if (notifCount === 0) {
                $("#ul_o").append('<li>No new notifications</li>');
            }
            $("#notif-count").text(notifCount);
            
            $(".notification-drop .item").on('click', function() {
                $(this).find('ul').toggle();
            });

            $("#userIcon").on('click', function(event) {
        event.stopPropagation(); // Prevents the click event from propagating to the document click event
        $(".user-dropdown-content").toggle(); // Toggles the visibility of the user dropdown content
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('.user-dropdown').length) {
            $(".user-dropdown-content").hide(); // Hides the dropdown content if clicked outside
        }
    });

    const destinationInput = document.getElementById('destination');

destinationInput.addEventListener('focus', function() {
    this.removeAttribute('placeholder');
});

destinationInput.addEventListener('blur', function() {
    if (!this.value.trim()) {
        this.setAttribute('placeholder', 'Enter destination');
    }
});


        });
  </script>
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                imageUrl: "/images/haha.gif",
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    </div>
</body>
</html>
