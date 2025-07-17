<?php
// Check if the connection is successful
$hostname = "localhost";
$username = "root";
$password = "";
$database = "grabout";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<?php
    $app = new App;
    $app->startingSession();

    define("APPURL", "http://localhost/restaurant%20Management");

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrabOut Restaurant Management</title>
    
    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- for swiper slider  -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

    <!-- fancy box  -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">

    <!-- custom css  -->
    <link rel="stylesheet" href="style.css">

    <style>
/* Add this to your existing styles or in a separate stylesheet */
.user-dropdown {
    position: relative;
    display: inline-block;
    
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(255, 255, 255, 0.2);
    z-index: 1;
    border-radius: 20px;
   
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    border-radius: 20px;

}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.user-dropdown:hover .dropdown-content {
    display: block;
}


</style>

</head>

<body class="body-fixed">

    <!-- start of header or Navbar  -->
    <header class="site-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header-logo">
                        <a href="index.php">
                            <h3>GrabOut</h3>
                            <!-- <img src="logo.png" width="160" height="36" alt="Logo"> -->
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="main-navigation">
                        <button class="menu-toggle"><span></span><span></span></button>
                        <nav class="header-menu">
                            <ul class="menu food-nav-menu">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="#about">About</a></li>
                                <li><a href="Menu.php">Menu</a></li>
                                <!-- <li><a href="#review">Review</a></li> -->
                                <li><a href="BookTable.php">Booking</a></li>
                                <li><a href="#contact">Contact</a></li>
                            </ul>
                        </nav>

                        <!-- Dark mode -->
                        <img src="assets/images/Dark mode/moon.png" id="d_icon" class="d_ico">



                        <!-- Search Box -->
                        <div class="header-right">
                            <form action="#" class="header-search-form for-des">
                                <input type="search" class="form-input" placeholder="Search Here...">
                                <button type="submit">
                                    <i class="uil uil-search"></i>
                                </button>
                            </form>
                            <!-- <php
      
                            $select_rows = mysqli_query($conn, "SELECT * FROM addcart ") or die('query failed');
                            $row_count = mysqli_num_rows($select_rows);

                            ?> -->
                            <?php
                                if (isset($_SESSION['username'])) :
                                    $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
                                    $select_rows = mysqli_query($conn, "SELECT * FROM addcart WHERE user_id = '$user_id'") or die('query failed');
                                    $row_count = mysqli_num_rows($select_rows);
                                ?>
                          
                            <!-- <php 
                            if(isset($_SESSION['username'])) : 
                            ?> -->

                            <a href="add-cart.php" class="header-btn header-cart">
                                <i class="uil uil-shopping-bag"></i>
                                <span class="cart-number"><?php echo $row_count; ?></span>
                            </a>
                            
                            <!-- <a href="login.php" class="header-btn">
                                <i class="uil uil-user-md"></i>
                            </a> -->
                            <div class="user-dropdown" id="userDropdown">
                                <a href="#" class="header-btn">
                                    <i class="uil uil-user-md"></i>
                                </a>
                                <div class="dropdown-content" id="dropdownContent">

                                    <a href="#"> <?php echo $_SESSION['username']; ?> </a>
                                    <a href="user_profile.php">Profile</a>
                                    <a href="logout.php">Logout</a>
                                </div>
                            </div>
                           
                            
                            <?php else : ?>
                            <a href="login.php" class="header-btn">
                                <i class="uil uil-user"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header ends  -->