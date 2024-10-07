<?php
session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'calorizen');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$bmr = null;

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $username = $_SESSION['username'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $activity_level = $_POST['activity_level'];

    // Insert query
    $sql = "UPDATE user SET height='$height', weight='$weight', age='$age', gender='$gender', activity_level='$activity_level' WHERE username='$username'";

    if (mysqli_query($conn, $sql)) {
        // Calculate BMR
        if ($gender === 'male') {
            $bmr = 10 * $weight + 6.25 * $height - 5 * $age + 5;
        } elseif ($gender === 'female') {
            $bmr = 10 * $weight + 6.25 * $height - 5 * $age - 161;
        }

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
    <title>Result BMR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Apply Poppins font to the whole page */
        }

        /* Align the title to the left */
        .title-left {
            text-align: left;
        }

        /* Center all other elements */
        .center-text {
            text-align: center;
        }

        /* Style for the line */
        .divider {
            margin: 30px 0; /* Reduced gap for the divider */
            border-top: 2px solid black; /* Black line */
        }

        /* Style for large text */
        .large-text {
            font-size: 50px; /* Font size around 50-65px */
            font-weight: 600;
        }

        /* Button styles */
        .button {
            padding: 12px 24px;
            background-color: #9eae45;
            color: white;
            font-weight: 600;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
            border: none; /* Removed border */
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Added shadow */
        }

        .button:hover {
            background-color: white; /* Change to white on hover */
            color: black; /* Text color changes to black on hover */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 1); /* Shadow becomes a bit darker on hover */
        }
    </style>
</head>
<body class="relative h-screen w-screen overflow-hidden bg-gray-100">
    <img class="w-full h-full object-cover absolute top-0 left-0" src="./assets/background-login.png" alt="login background"> 
    
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 shadow-lg rounded-lg w-[500px]">
        <h2 class="text-2xl font-bold mb-6 title-left">Your Result</h2>

        <div class="center-text">
            <?php if (isset($_GET['bmr'])): ?>
                <p class="large-text mb-4"><?php echo htmlspecialchars($_GET['bmr']); ?> kcal</p> <!-- Display calculated BMR -->
            <?php else: ?>
                <p class="large-text mb-4">BMR not available</p>
            <?php endif; ?>
        </div>

        <div class="divider"></div>

        <div class="center-text mb-12">
            <p class="text-xl">Total calories you should consume daily</p>
        </div>

        <div class="center-text mb-8">
            <p class="text-xl">Choose your goal:</p>
        </div>

        <div class="flex justify-center gap-4">
            <a href="home2.html"><button class="button">Surplus</button></a>
            <a href="home2.html"><button class="button">Deficit</button></a>
        </div>
    </div>
</body>
</html>
