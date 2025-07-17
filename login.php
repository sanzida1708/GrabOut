<?php require "config/config.php"; ?>
<?php require "libs/App.php"; ?>
<?php require "includes/header.php"; ?>
<?php


$app = new App;
$app->validateSession();

if(isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = "SELECT * FROM users WHERE email='$email'";



    $data = [

        "email" => $email,       
        "password" => $password,

    ];

    // $path = "index.php";
    $path = "http://localhost/restaurant%20Management";

    $app->login($query,$data,$path);


}
?>


     <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('assets/images/faq-bg.png');
            background-size: cover;
            background-position: center;
        }

        .login-container {
            background-color: var(--primary-color);
            border-radius: 8px;
            box-shadow: 0 0 10px rgb(230, 230, 230);
            padding: 20px;
            width: 50%; /* Adjusted for responsiveness */
            max-width: 450px; /* Added for responsiveness */
            animation: fadeIn 0.6s ease-out;
        }

      

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            font-weight: 500;
            color: var(--secondary-color);
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        button {
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            font-weight: 500;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .login-form a {
            color: #088ee7;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .login-form a:hover {
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

        h2 {
            text-align: center;
            color: var(--secondary-color);
        }

         /* Responsive adjustments */
    @media (max-width: 768px) {
        .login-container {
            width: 80%;
            margin-top: 100px; /* Add some top margin for spacing */
        }
    }
    </style>
    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button name="submit" type="submit">Login</button>

            <!-- New links for Forgot Password and Sign Up -->
            <!-- <p>
                <a href="forgotPassword.php">Forgot Password?</a>
            </p> -->
            <div>
                <p>Want to Create a New Account? ||
                <a href="SignUp.php">SignUp</a> </p>
            </div>
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
