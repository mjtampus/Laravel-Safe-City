
<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="/css/dashboard-container.css">
    <link rel="stylesheet" href="/css/createAnnouncement.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
        <div class="container">
            <div class="header">
                <h1>Create Announcement</h1>
            </div>
            <form method="post" action="{{ url('/announcements') }}">
                @csrf
                <div class="announcement-container">
                    <div class="announcement-details">
                        <div class="details">
                            <div class="title">
                                <p style="color: red; font-weight: bolder;">Title :</p>
                                <input type="text" id="title" name="title">
                            </div>
                        </div>
                    </div>
                    <div class="description">
                        <p style="color: red; font-weight: bolder;">Description:</p>
                        <textarea name="message" id="announcement-description" cols="30" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="position: relative; left: 90%;">publish</button>
                </div>
            </form>
        </div>
    </main>
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