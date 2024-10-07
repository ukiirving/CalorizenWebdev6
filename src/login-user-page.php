<?php
// Database connection
// Assuming this is part of your login logic
session_start(); // Start a session



$conn = mysqli_connect('localhost', 'root', '', 'calorizen');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if (isset($_GET['submit'])) {
    // Get form data
    $username = $_GET['username'];
    $password = $_GET['password'];

    // Select query to check user credentials
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // User found, redirect to user dashboard or appropriate page
        // After successful login
$_SESSION['username'] = $username; // Store the username in the session
header("location:./calculator.php"); // Redirect to the next page
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password.";
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
    <title>Log In Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .admin-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 2rem;
            height: 2rem;
        }
    </style>
</head>
<body class="relative h-screen w-screen overflow-hidden bg-gray-100">
    <img class="w-full h-full object-cover absolute top-0 left-0" src="./assets/background-login.png" alt="login background"> 

    <a href="login-admin-page.php">
        <img src="./assets/admin-icon.png" alt="admin icon" class="admin-icon">
    </a>

    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 shadow-lg rounded-lg w-96">
        <a href="index.html">
            <img class="absolute top-4 right-4" src="./assets/close button.png" alt="close icon">
        </a>
        <h2 class="text-2xl font-bold mb-6 text-center">Log In</h2>
        <form method="GET">
            <!-- Input Username -->
            <div class="mb-4 relative">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="Enter your username">
            </div>
            
            <!-- Input Password -->
            <div class="mb-6 relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required placeholder="••••••••">
            </div>

            <!-- Error message -->
            <?php if (isset($error_message)): ?>
                <div class="mb-4 text-red-600 text-center"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <!-- Tombol Login -->
            <button type="submit" name="submit" class="w-full bg-[#9eae45] text-white py-2 px-4 rounded-md hover:bg-[#8ea23e] transition duration-150 ease-in-out">Log In</button>

            <!-- Teks untuk pendaftaran -->
            <p class="mt-4 text-center text-gray-600">
                Or <a href="sign-up-page.php" class="text-indigo-600 hover:underline">register here</a>
            </p>
        </form>
    </div>
</body>
</html>
