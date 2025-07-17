<?php require "config/config.php"; ?>
<?php require "libs/App.php"; ?>
<?php require "includes/header.php"; ?>
<?php


$app = new App;
$app->validateSession();

if(isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];


    $query = "INSERT INTO users (username, email, phone, password, address) VALUES (:username,
    :email, :phone, :password, :address)";

    $arr = [
        ":username" => $username,
        ":email" => $email,       
        ":phone" => $phone,
        ":password" => $password,
        ":address" => $address,
    ];

    $path = "login.php";

    $app->register($query,$arr,$path);
}
?>


    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            /* background-color: #f4f4f4; */
            background-image: url('assets/images/faq-bg.png'); 
            background-size: cover;
            background-position: center;
        }

        .signup-container {
            /* background-color: #fff; */
            background-color:var(--primary-color);
            border-radius: 8px;
            box-shadow: 0 0 10px rgb(239, 236, 236);
            padding: 20px;
            width: 450px;
            animation: fadeIn 0.6s ease-out;
            margin-top: 100px;

            position: fixed; /* Add this line to make it fixed */
            top: 0; /* Position at the top of the viewport */
            z-index: 1000; /* Set a high z-index to ensure it's above other elements */

            
    
        }

        .signup-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            color: var(--secondary-color);
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        button {
            padding: 8px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* New styles for links */
        .signup-form a {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
        }

        .signup-form a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        h2{
            text-align: center;
            color: var(--secondary-color);
        }

              /* Responsive adjustments */
    @media (max-width: 768px) {
        .signup-container {
            width: 80%;
            margin-top: 100px; /* Add some top margin for spacing */
        }
    }
    </style>

    <div class="signup-container">
        <h2>Sign Up</h2>
        <form class="signup-form" method="POST" action="signUp.php">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phoneNumber">Phone Number:</label>
            <input type="tel" id="phoneNumber" name="phone" required>


            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="address">Address/Location:</label>
            <textarea id="address" name="address" rows="" required></textarea>

           

            <button name ="submit" type="submit">Sign Up</button>

            <!-- New link for returning to the login page -->
            <p>
                Already have an account? || <a href="login.php">Login</a>
            </p>
        </form>
    </div>


    <script>


        var d_icon = document.getElementById("d_icon");
    
        d_icon.onclick = function(){
            document.body.classList.toggle("dark-theme");
    
            if(document.body.classList.contains("dark-theme")){
                d_icon.src = "assets/images/Dark mode/sun.png";
            }else{
                d_icon.src = "assets/images/Dark mode/moon.png";
            }
        }
    
    
    </script>    

</body>
</html>
