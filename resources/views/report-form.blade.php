<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css">
    <title>Accident Report Form</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #e6bbf2;
            
            
        }
        body h1 {
            color: black;
 /* Will override color (regardless of order) */
            -webkit-text-stroke-width: 1px;
            -webkit-text-stroke-color: black;
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            color: white;
        }

        .card {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.8);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            position: relative;
  height: 50px;
  width: 100%;
  outline: none;
  font-size: 1rem;
  color: #707070;
  margin-top: 8px;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 0 15px;

        }


        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border-radius: 10px;
            
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-select {
    position: relative;
    width: 100%;
}

select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    appearance: none; /* Remove default arrow on WebKit/Blink browsers */
    -webkit-appearance: none; /* Remove default arrow on Firefox */
    cursor: pointer;
}

.select-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
}

/* Optional: Add styles for the arrow icon */
.select-icon i {
    font-size: 1.5rem;
    color: #555;
}
    </style>
</head>

<body>

    <h1>Accident Report Form</h1>

    <div class="card">
        <form method="post" action="{{ route('submit-report') }}" enctype="multipart/form-data">
            @csrf
            <label for="latitude"></label>
            <input type="hidden" id="latitude" name="latitude" readonly>

            <label for="longitude"></label>
            <input type="hidden" id="longitude" name="longitude" readonly>

<label for="name">Type of Incident</label>
<div class="custom-select">
    <select name="name" id="name" onchange="handleIncidentTypeChange(this)">
        <option value="CarAccident">Car Accident</option>
        <option value="MotorcycleAccident">Motorcycle Accident</option>
        <option value="Robbery">Robbery</option>
        <option name="yawa" value= "Others">Others</option>
    </select>
    <div class="select-icon">
        <i class='bx bx-chevron-down'></i>
    </div>
</div>

<div id="othersInput" style="display: none;">
            <label for="otherDescription">Specify Other Incident</label>
             <input type="text" name="other_description" id="otherDescription">
</div>
            <label for="email">Your Email:</label>
            <input type="text" id="email" name="email" value="{{ $user->email }}" placeholder="Your email">

            <label for="description">Accident Description:</label>
            <textarea id="description" name="description" rows="4" placeholder="Describe the accident..."></textarea>


            <label for="image">Upload Image:</label>
            <input type="file" id="image_url" name="image_url" accept="image/*">

            <button type="submit">Submit Report</button><br><br>

            <a href="{{ route('dashboard') }}">Cancel</a>
        </form>
    </div>

    <script src='/js/report-form.js'></script>

</body>

</html>

<script>
 function handleIncidentTypeChange(selectElement) {
    // Get the selected value
    var selectedValue = selectElement.value;
    var showInput = document.getElementById('othersInput');
    // Get the "Others" input element
    var othersInput = document.getElementById('otherDescription');

    // Change the name attribute of the text input based on the selected value
    if (selectedValue === 'Others') {
        othersInput.setAttribute('name', 'name');
        showInput.style.display = 'block';
    } else {
        othersInput.setAttribute('name', 'other_description');
        showInput.style.display = 'none';
    }
}
</script>