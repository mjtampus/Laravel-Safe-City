<!-- resources/views/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/login.css">
    <title>Login</title>
</head>
<body>

    <video id="video-background" autoplay loop muted>
        <source src="/video/bg.mp4" type="video/mp4">
        <!-- You can add multiple source elements for different video formats -->
        
    </video>

    <div class="cont" id="welcome-container">
        <h1 id="welcome-text">WELCOME TO SAFECITY</h1>
        <div id="arrow-icon">
        <button class="arrow-button">Login<span class="arrow"></span>
        </div>
</button>

        </div>
    </div>

    <section class="container" id="login-container">
        <h1>Login</h1>
        
        @if(session('error'))
            <p id="login-error" style="color: red;">{{ session('error') }}</p>
        @endif

        <form action="{{ route('login') }}" method="post" class="form">
            @csrf
            
            <div class="input-box address">
                <label for="email">Email</label>
                <input type="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <br><br>
            Don't have an account?
            <a href="register">Register now</a>
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>document.addEventListener("DOMContentLoaded", function () {
    const welcomeContainer = document.getElementById("welcome-container");
    const loginContainer = document.getElementById("login-container");
    const arrowIcon = document.getElementById("arrow-icon");

    arrowIcon.addEventListener("click", function () {
        welcomeContainer.style.display = "none";
        loginContainer.style.display = "block";
    });
});
</script>
@if(session('success'))
<script>

Swal.fire({
  position: "center",
  icon: "success",
  title: '{{ session('success') }}',
  showConfirmButton: false,
  timer: 1500
});

</script>
@endif
</body>
</html>
