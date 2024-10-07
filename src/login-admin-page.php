<?php
// Database connection
session_start(); // Start a session

$conn = mysqli_connect('localhost', 'root', '', 'calorizen');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Select query to check user credentials
    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // User found, redirect to user dashboard or appropriate page
        $_SESSION['username'] = $username; // Store the username in the session
        header("Location: ./admin.html"); // Redirect to the next page
        exit();
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
    <title>Log In Admin Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .input-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            width: 1.5rem;
            height: 1.5rem;
            color: #6b7280; /* Tailwind's gray-500 */
        }
    </style>
</head>
<body class="relative h-screen w-screen overflow-hidden bg-gray-100">
    <img class="w-full h-full object-cover absolute top-0 left-0" src="./assets/background-login.png" alt="login background"> 

    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 shadow-lg rounded-lg w-96">
        <a href="index.html">
            <img class="absolute top-4 right-4" src="./assets/close button.png" alt="close icon">
        </a>
        <h2 class="text-2xl font-bold mb-6 text-center">Log In Admin</h2>
        <form method="POST">
            <!-- Input Username -->
            <div class="mb-4 relative">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <div class="relative">
                    <input name="username" type="text" id="username" class="mt-1 block w-full px-4 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="you@example.com" required>
                    <img src="./assets/email-icon.png" alt="email icon" class="input-icon">
                </div>
            </div>
            
            <!-- Input Password -->
            <div class="mb-6 relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input name="password" type="password" id="password" class="mt-1 block w-full px-4 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="••••••••" required>
                    <img src="./assets/key-icon.png" alt="key icon" class="input-icon">
                </div>
            </div>

            <!-- Error message -->
            <?php if (isset($error_message)): ?>
                <div class="mb-4 text-red-600 text-center font-bold"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <!-- Tautan Forgot Password -->
            <div class="mb-4 flex justify-end">
                <a href="#" class="text-indigo-600 hover:underline">Forgot Password?</a>
            </div>

            <!-- Tombol Login -->
            <button type="submit" name="submit" class="w-full bg-[#9eae45] text-white py-2 px-4 rounded-md hover:bg-[#8ea23e] transition duration-150 ease-in-out">
                Log In
            </button>
        </form>
    </div>
</body>
</html>
