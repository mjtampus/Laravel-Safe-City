<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Leaderboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap">
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f5f0ff; /* Light purple background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        main {
            text-align: center;
            color: #333; /* Dark text color */
        }

        h1 {
            margin-bottom: 20px;
            color: #673ab7; /* Purple header color */
        }

        ol {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            margin: 5px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(103, 58, 183, 0.1); /* Light purple shadow */
        }

        .ok-button {
            background-color: #673ab7; /* Purple button color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .ok-button:hover {
            background-color: #512da8; /* Darker shade on hover */
        }
    </style>
</head>

<body>
    <main>
        <h1>User Leaderboard</h1>

        <ol>
            @foreach ($leaderboard as $user)
                <li>
                    <strong>{{ $user->name }}</strong>
                    <p>Email: {{ $user->email }}</p>
                    <p>Confirmed Reports: {{ $user->confirmed_reports_count }}</p>
                </li>
            @endforeach
        </ol>

        <button class="ok-button" onclick="redirectToDashboard()">Ok</button>
    </main>

    <script>
        function redirectToDashboard() {
            window.location.href = '/dashboard'; // Replace '/dashboard' with the actual URL of your dashboard
        }
    </script>
</body>

</html>
