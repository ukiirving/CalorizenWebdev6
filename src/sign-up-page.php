<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'calorizen');


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Insert query
    $sql = "INSERT INTO user (id, username, password) VALUES ('$id', '$username', '$password')";


    if (mysqli_query($conn, $sql)) {
        header("location:./login-user-page.php?message=input");
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
    <title>Sign Up Page</title>
    <!-- Menggunakan Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Link ke Google Fonts untuk font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .transition-transform {
            transition: transform 0.3s ease;
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
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="relative h-screen w-screen overflow-hidden bg-gray-100">
    <!-- Gambar background -->
    <img class="w-full h-full object-cover absolute top-0 left-0" src="./assets/background-login.png" alt="login background"> 

    <!-- Kotak login -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 shadow-lg rounded-lg w-96">
        <!--close i-->
        <img class="absolute top-4 right-4" src="./assets/close button.png" alt="close icon">
        <!-- Judul kotak login -->
        <h2 class="text-2xl font-bold mb-6 text-center">Sign Up</h2>
        <!-- Formulir login -->
        <form action="sign-up-page.php" method="post">
            <!-- Input Email dengan ikon di kanan -->
            <div class="mb-4 relative">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <div class="relative">
                    <input type="username" id="username" name="username" class="mt-1 block w-full px-4 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Username here">
                    <img src="./assets/email-icon.png" alt="username icon" class="input-icon">
                </div>
            </div>
            
            <!-- Input Password dengan ikon di kanan -->
            <div class="mb-6 relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="mt-1 block w-full px-4 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="••••••••">
                    <img src="./assets/key-icon.png" alt="key icon" class="input-icon">
                </div>
            </div>

            <!-- Tombol Sign Up -->
             <div>
             <tr>
                <td>
                    <input type="submit" name="submit" class="w-full bg-[#9eae45] text-white py-2 px-4 rounded-md hover:bg-[#8ea23e] transition duration-150 ease-in-out block text-center" value="Sign Up" href="./login-user-page.html">
                </td>
             </tr>
             </div>
        </form>
    </div>
</body>
</html>
