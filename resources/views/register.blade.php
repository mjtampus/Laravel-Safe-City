<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Register</title>
</head>
<body>
<section class="container">
    <form action="{{ route('register') }}" method="post" class="form">
        <h3>Register now</h3>
        @csrf
        <div class="input-box">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter Your Name" required>

        </div>

        <div class="input-box">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" placeholder="Enter Your LastName" required>

        </div>

        <div class="column">
            <div class="input-box">
                <label for="phone">Phone</label>
                <input type="tel" name="phone" required>
                @error('phone')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-box">
                <label for="age">Age</label>
                <input type="number" name="age" required>

            </div>
        </div>

        <div class="gender-box">
            <h3>Gender</h3>
            <div class="gender-option">
                <div class="gender">
                    <input type="radio" id="check-male" name="gender" value="Male" checked />
                    <label for="check-male">Male</label>
                </div>
                <div class="gender">
                    <input type="radio" id="check-female" name="gender" value="female" />
                    <label for="check-female">Female</label>
                </div>

                <div class="gender">
                    <input type="radio" id="check-female" name="gender" value="Bayot" />
                    <label for="check-Bayot">Bayot</label>
                </div>

                <div class="gender">
                    <input type="radio" id="check-female" name="gender" value="Tomboy" />
                    <label for="check-Tomboy">Tomboy</label>
                </div>
                <div class="gender">
                    <input type="radio" id="check-female" name="gender" value="Dipa Sure" />
                    <label for="check-Tomboy">Dipa sure</label>
                </div>
            </div>
            @error('gender')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="input-box address">
            <label for="email">Email</label>
            @error('email')
                <p style="color: red;">{{ $message }}</p>
            @enderror
            <input type="email" name="email" required>

            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" required>


            <label for="password">Password</label>
            @error('password')
                @foreach($errors->get('password') as $message)
                    <p style="color: red;">{{ $message }}</p>
                @endforeach
            @enderror
            <input type="password" name="password" class="box" required>

            <label for="password_confirmation">Confirm Password</label>
            @error('password_confirmation')
                <p style="color: red;">{{ $message }}</p>
            @enderror
            <input type="password" name="password_confirmation" class="box" required>

        </div>
        <button type="submit" class="btn">Register</button>
        <br><br>
        Already have an account?
        <a href="login">Log in now!</a>
    </form>
</section>
</body>
</html>
