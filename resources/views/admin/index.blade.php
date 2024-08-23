<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2; /* Light gray background */
            color: #333; /* Dark text color */
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #663399; /* Purple header color */
        }

        div {
            background-color: #fff; /* White background for each announcement */
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Light shadow */
        }

        p {
            margin: 0;
        }

        hr {
            border: none;
            height: 1px;
            background-color: #ddd; /* Light gray horizontal rule */
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .dashboard-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #663399; /* Purple background */
            color: #fff; /* White text color */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .dashboard-link:hover {
            background-color: #512b6d; /* Darker purple on hover */
        }
    </style>
</head>
<body>
    <h1>Announcements</h1>

    @foreach($announcements as $announcement)
        <div>
            <Strong>{{ $announcement->title }} </Strong>        
            <br>   
            <br>
            <p>{{ $announcement->message }}</p>
            <hr>
        </div>
    @endforeach
    <a href="{{ route('dashboard') }}" class="dashboard-link">Go to Dashboard</a>
</body>
</html>
