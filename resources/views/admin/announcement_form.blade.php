<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement</title>
</head>
<body>
    <h1>Create Announcement</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ url('/announcements') }}" method="post">
        @csrf
        <label for="message">Message:</label>
        <textarea name="message" id="message" cols="30" rows="5"></textarea>
        <br>
        <button type="submit">Create Announcement</button>
    </form>
</body>
</html>