<?php
include('Admin/header.php');
require "config/config.php";
require "libs/App.php";

// Check if the connection is successful
$hostname = "localhost";
$username = "root";
$password = "";
$database = "grabout";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($conn) {
    if (isset($_POST['submit'])) {
        $f_name = $_POST['foodName'];
        $f_image = $_FILES['foodImage']['name'];
        $f_image_tmp_name = $_FILES['foodImage']['tmp_name'];
        $f_image_folder = $_SERVER['DOCUMENT_ROOT'] . '/Restaurant Management/uploaded_img/' . $f_image;

        // Ensure the directory exists, create it if not
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/Restaurant Management/uploaded_img/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $f_mealType = $_POST['mealType'];
        $f_description = $_POST['description'];
        $f_price = $_POST['price'];

        // Remove the single quotes around the table name 'menu'
        $insert_query = mysqli_query($conn, "INSERT INTO menu (foodName, foodImage, mealType, description, price) VALUES ('$f_name', '$f_image','$f_mealType', '$f_description', '$f_price')") or die('query failed');

        if ($insert_query) {
            move_uploaded_file($f_image_tmp_name, $f_image_folder);
            $message[] = 'product added successfully';
        } else {
            $message[] = 'could not add the product: ' . mysqli_error($conn);
        }
    }
} else {
    $message[] = 'Database connection failed';
}
?>


<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            max-width: 1200px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top:50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        select {
            appearance: none;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }

        button:hover {
            background-color: #45a049;
        }
        h2{
            text-align: center;
        }
        .message{
            background-color: blue;
            position: sticky;
            top:0; left:0;
            z-index: 10000;
            border-radius: .5rem;
            background-color: white;
            padding:1.5rem 2rem;
            margin:0 auto;
            max-width: 1800px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap:1.5rem;
}

.message span{
   font-size: 2rem;
   color: black;
}

.message i{
   font-size: 2.5rem;
   color: black;
   cursor: pointer;
}

.message i:hover{
   color:red;
}
</style>

<div class="form-container">
    <h2>Add Food Item</h2>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="foodName">Food Name:</label>
            <input type="text" id="foodName" name="foodName" required>
        </div>

        <div class="form-group">
            <label for="foodImage">Food Image:</label>
            <input type="file" id="foodImage" name="foodImage" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="mealType">Meal Type:</label>
            <select id="mealType" name="mealType" required>
                <option value="1">Fastfood</option>
                <option value="2">Dessert</option>
                <option value="3">Set menu</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Food Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Food Price:</label>
            <input type="text" id="price" name="price" required>
        </div>

        <button name="submit" type="submit">Add Food Item</button>
    </form>
</div>


<?php
include('Admin/footer.php'); 
?>