<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Marker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Rubik', sans-serif;
            background-color: #f5f0ff; /* Light purple background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            box-shadow: 0 0 10px rgba(103, 58, 183, 0.2); /* Light purple shadow */
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            color: #673ab7; /* Purple header color */
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333; /* Dark text color */
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff; /* White background */
            color: #333; /* Dark text color */
        }

        button {
            background-color: #673ab7; /* Purple button color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #512da8; /* Darker shade on hover */
        }

        /* Anchor tag styling */
        .btn-like {
            display: inline-block;
            padding: 10px 20px;
            background-color: #673ab7; /* Purple button color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            position: absolute;
            top: 10px;
            right: 10px;
            transition: background-color 0.3s;
        }

        .btn-like:hover {
            background-color: #512da8; /* Darker shade on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Choose Your Marker</h2>

        <form method="POST" action="{{ route('updateChosenMarker') }}">
            @csrf

            <label for="chosen_marker">Select Marker:</label>
            <select name="chosen_marker" id="chosen_marker" required>
                <!-- Add options for different markers -->
                <option value="ace3.png">Ace Marker</option>
                <option value="yellowmarker.png">Yellow Marker</option>
                <option value="default">Default</option> <!-- Corrected the typo in "value" attribute -->
                <!-- Add more options as needed -->
            </select>

            <button type="submit">Save Marker</button>
        </form>

        <!-- Anchor tag for the dashboard button -->
        <a href="{{ url('/dashboard') }}" class="btn-like">Go to Dashboard</a>
    </div>
</body>

</html>
