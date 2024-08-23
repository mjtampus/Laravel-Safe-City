<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <title>Accident Report Details</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3e8ff; /* Light purple background */
            font-family: 'Your Font Name', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            background-color: #fff; /* White card background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #6a0572; /* Darker shade of purple for heading */
            margin-bottom: 20px;
        }

        p {
            color: #4f0063; /* Dark purple text color */
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px; /* Rounded corners for the image */
            margin-bottom: 20px;
        }

        a {
            color: #6a0572; /* Darker shade of purple for links */
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #380031; /* Darker shade on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h1>Accident Report Details</h1>

            <p>Name: {{ $report->name }}</p>
            <p>Email: {{ $report->email }}</p>
            <p>Description: {{ $report->description }}</p>
            <p>Location Status: {{ $report->location_status === 1 ? 'Confirmed' : 'Pending' }}</p>
            <p>Image: <img src="/{{ $report->image_url }}" alt="Report Image"></p>

            <!-- Display the map or other details as needed -->

            <a href="{{ route('dashboard') }}">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>
