<?php
session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'calorizen');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $username = $_SESSION['username'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $activity_level = $_POST['activity_level'];

    // Calculate BMR
    if ($gender === 'male') {
        $bmr = 10 * $weight + 6.25 * $height - 5 * $age + 5;
    } elseif ($gender === 'female') {
        $bmr = 10 * $weight + 6.25 * $height - 5 * $age - 161;
    }

    // Insert query
    $sql = "UPDATE user SET height='$height', weight='$weight', age='$age', gender='$gender', activity_level='$activity_level', bmr='$bmr' WHERE username='$username'";

    if (mysqli_query($conn, $sql)) {
        // Redirect to result page with BMR value
        header("Location: result.php?bmr=" . urlencode($bmr) . "&activity_level=" . urlencode($activity_level));
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator BMR</title>
    <!-- Menggunakan Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Link ke Google Fonts untuk font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Apply Poppins font to the whole page */
        }

        /* Hide radio buttons */
        input[type="radio"] {
            display: none;
        }

        /* Style the labels like buttons */
        .gender-button {
            width: 240px; /* Keep original width */
            height: 60px; /* Keep original height */
            border-radius: 0.375rem; /* rounded-md in Tailwind */
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            background-color: white; /* Initial background color */
            color: black; /* Initial text color */
            border: 2px solid black; /* Initial border color */
            text-align: center; /* Center align text */
            display: flex; /* Use flexbox for centering */
            align-items: center; /* Center text vertically */
            justify-content: center; /* Center text horizontally */
            font-family: 'Poppins', sans-serif; /* Apply Poppins font to buttons */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Add shadow below button */
        }

        input[type="radio"]:checked + .gender-button {
            background-color: #9eae45; 
            color: white; 
            border: 2px solid #9eae45; 
        }

        .form-input {
            width: calc(33.33% - 10px);
            border-radius: 0.375rem; 
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border: 2px solid black; 
            background-color: white;
        }

        .form-input input {
            width: 100%;
            height: 100%; 
            border: none; 
            text-align: center;
            font-family: 'Poppins', sans-serif; 
            outline: none; 
        }

        .calculate-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background-color: #9eae45; 
            color: white; 
            font-weight: 600;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .calculate-button:hover {
            background-color: white; 
            color: black;
            border: 2px solid black; 
        }

        .calculate-button span {
            margin-left: 8px;
        }

        
        .title-left {
            text-align: left;
        }

        .select-dropdown {
            width: 100%;
            height: 3rem; 
            border: 2px solid black;
            border-radius: 0.375rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            background-color: white;
            font-family: 'Poppins', sans-serif; 
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .select-dropdown:hover, .select-dropdown:focus {
            border-color: #9eae45; 
            background-color: #f0f9e8; 
        }
    </style>
</head>
<body class="relative h-screen w-screen overflow-hidden bg-gray-100">
    <img class="w-full h-full object-cover absolute top-0 left-0" src="./assets/background-login.png" alt="login background"> 

    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 shadow-lg rounded-lg w-[500px]">
        <h2 class="text-2xl font-bold mb-6 title-left">Calorie Calculator</h2>

        <form method="POST">
        <div class="text-left mb-2">
            <label class="block text-sm font-medium text-gray-700">Gender</label>
        </div>

        <div class="flex justify-center gap-4 mb-6">
            <input type="radio" id="male" name="gender" value="male">
            <label for="male" class="gender-button">Male</label>

            <input type="radio" id="female" name="gender" value="female">
            <label for="female" class="gender-button">Female</label>
        </div>

        <div class="flex gap-4 mb-6">
            <div class="form-input">
                <input type="number" id="age" name="age" placeholder="Age" required>
            </div>

            <div class="form-input">
                <input type="number" id="weight" name="weight" placeholder="Weight (kg) required">
            </div>

            <div class="form-input">
                <input type="number" id="height" name="height" placeholder="Height (cm) required">
            </div>
        </div>

        <div class="mb-6">
            <label for="activity-level" class="block text-sm font-medium text-gray-700 mb-2">Activity Level</label>
            <select id="activity-level" name="activity_level" class="select-dropdown required">
                <option value="" disabled selected>Select your activity level</option>
                <option value="lightly-active">Lightly Active (1-3 days to workout/week)</option>
                <option value="moderately-active">Moderate Active (4-5 days to workout/week)</option>
                <option value="very-active">Very Active (6-7 days to workout/week)</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center">
                <button type="submit" name="submit" class="w-full bg-[#9eae45] text-white py-2 px-4 rounded-md hover:bg-[#8ea23e] transition duration-150 ease-in-out">
                    Calculate
                    <span>&rarr;</span>
                </button>
        </div>
        </form>
    </div>
</body>
</html>
