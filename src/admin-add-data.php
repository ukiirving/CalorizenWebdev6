<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'calorizen');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $calories = $_POST['calories'];
    $proteins = $_POST['proteins'];
    $carbohydrates = $_POST['carbohydrates'];
    $fats = $_POST['fats'];
    $energy = $_POST['energy'];
    $description = $_POST['description'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (limit to 2MB)
        if ($_FILES['image']['size'] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Prepare and bind
                $stmt = $conn->prepare("INSERT INTO foods (name, calories, proteins, carbohydrates, fats, energy, image, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $name, $calories, $proteins, $carbohydrates, $fats, $energy, $target_file, $description);

                // Execute the statement
                if ($stmt->execute()) {
                    header("Location: ./admin.html?message=input");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded or there was an upload error.";
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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/01057ef582.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">
    <div>
        <nav class="bg-[#9EAE45] flex items-center justify-between drop-shadow-xl">
            <div class="flex items-center bg-[#84A313] py-5 px-6 h-full">
                <i class="fa-solid fa-wrench text-white mr-2 drop-shadow-xl"></i>
                <h1 class="text-white text-xl font-bold drop-shadow-xl">Admin Panel</h1>
            </div>
            <a href="index.html">
                <i class="fa-solid fa-right-from-bracket text-white p-6"></i>
            </a>
        </nav>
    </div>

    <div class="w-full max-w-md mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg relative">
        <a href="admin.html">
            <i class="fa-solid fa-xmark absolute top-4 right-4 text-gray-700 cursor-pointer text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold mb-4 text-left">Add Data</h2>
        <form method="POST">
            <div class="mb-1">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-1">Food/Drink Name</label>
                <input type="text" id="name" name="name" placeholder="Name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="flex space-x-2 mb-2">
                <div class="flex-1">
                    <label for="calories" class="block text-gray-700 text-sm font-bold mb-1">Calorie</label>
                    <div class="flex">
                        <input type="text" id="calories" name="calories" placeholder="0" required class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-blue-500">
                        <span class="flex items-center px-3 py-2 border border-gray-300 border-l-0 rounded-r-lg text-gray-700 text-sm">kcal</span>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="category" class="block text-gray-700 text-sm font-bold mb-1">Category</label>
                    <select id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                        <option value="food">Food</option>
                        <option value="drink">Drink</option>
                    </select>
                </div>
            </div>
            <div class="mb-2">
                <label for="carbohydrates" class="block text-gray-700 text-sm font-bold mb-1">Carbs</label>
                <div class="flex">
                    <input type="text" id="carbohydrates" name="carbohydrates" placeholder="0" required class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-blue-500">
                    <span class="flex items-center px-3 py-2 border border-gray-300 border-l-0 rounded-r-lg text-gray-700 text-sm">gr</span>
                </div>
            </div>
            <div class="mb-2">
                <label for="proteins" class="block text-gray-700 text-sm font-bold mb-1">Protein</label>
                <div class="flex">
                    <input type="text" id="proteins" name="proteins" placeholder="0" required class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-blue-500">
                    <span class="flex items-center px-3 py-2 border border-gray-300 border-l-0 rounded-r-lg text-gray-700 text-sm">gr</span>
                </div>
            </div>
            <div class="mb-2">
                <label for="fats" class="block text-gray-700 text-sm font-bold mb-1">Fat</label>
                <div class="flex">
                    <input type="text" id="fats" name="fats" placeholder="0" required class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-blue-500">
                    <span class="flex items-center px-3 py-2 border border-gray-300 border-l-0 rounded-r-lg text-gray-700 text-sm">gr</span>
                </div>
            </div>
            <div class="mb-2">
                <label for="energy" class="block text-gray-700 text-sm font-bold mb-1">Energy</label>
                <div class="flex">
                    <input type="text" id="energy" name="energy" placeholder="0" required class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-blue-500">
                    <span class="flex items-center px-3 py-2 border border-gray-300 border-l-0 rounded-r-lg text-gray-700 text-sm">kJ</span>
                </div>
            </div>
            <div class="flex space-x-2 mb-4">
                <div class="flex-1">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-1">Add Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="flex-1">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-1">Short Description</label>
                    <input type="text" id="description" name="description" placeholder="Description" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" name="submit" class="bg-[#9EAE45] text-white px-4 py-2 rounded hover:bg-green-600">
                    Save
                </button>
            </div>
        </form>
    </div>
</body>
</html>
