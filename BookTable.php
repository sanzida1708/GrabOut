<?php
require "config/config.php";
require "libs/App.php";
require "includes/header.php";

// Check if the connection is successful
$hostname = "localhost";
$username = "root";
$password = "";
$database = "grabout";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Initialize the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $c_name = $_POST['name'];
    $c_phonenumber = $_POST['phonenumber'];
    $c_email = $_POST['email'];
    $c_userid = $_POST['user_id'];
    $c_address = $_POST['address'];
    $no_of_person = $_POST['select1'];
    $special_request = $_POST['special_request'];
    $booking_date = $_POST['time'];

    // Insert data into the database
    $insertQuery = "INSERT INTO booktable (c_name, c_phonenumber, c_email,c_user_id, c_address, no_of_person, special_request, booking_date)
                    VALUES ('$c_name', '$c_phonenumber', '$c_email','$c_userid','$c_address', '$no_of_person', '$special_request', '$booking_date')";

    $result = mysqli_query($conn, $insertQuery);

    // if ($result) {
    //     echo "<div class='alert alert-success'>Data inserted successfully!</div>";
    // } else {
    //     echo "<div class='alert alert-danger'>Error inserting data: " . mysqli_error($conn) . "</div>";
    // }

    // Close the database connection
    mysqli_close($conn);
}
?>


     <!-- BOOK TABLE -->


            <section class="book-table section">
                <div class="book-table-shape">
                    <img src="assets/images/table-leaves-shape.png" alt="">
                </div>

                <div class="book-table-shape book-table-shape2">
                    <img src="assets/images/table-leaves-shape.png" alt="">
                </div>

                <div class="sec-wp">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sec-title text-center mb-5">
                                    <p class="sec-sub-title mb-3">Book Table</p>
                                    <h2 class="h2-title">Opening Table</h2>
                                    <div class="sec-title-shape mb-4">
                                        <img src="assets/images/title-shape.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="book-table-info">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="table-title text-center">
                                        <h3>Monday to Thrusday</h3>
                                        <p>9:00 am - 22:00 pm</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="call-now text-center">
                                        <i class="uil uil-phone"></i>
                                        <a href="tel:+880-1234567890">+880 - 1234567890</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="table-title text-center">
                                        <h3>Friday to Sunday</h3>
                                        <p>11::00 am to 20:00 pm</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Form -->

                        <div class="container-xxl py5 px-0 wow fadeInUp bg-dark align-items-center">

                            <!-- <h3 class="section-title">
                                Reservation
                            </h3> -->
                            <h1 class="text-warning mb-4 text-center"style="padding-Top: 20px;">
                                Book A Table Online
        
                            </h1>
                            <form method="post" action="">
                                <div class="row g-3">
                                    <div class="form-info mt-5">
                                        <div class="container container-oder">
                                            <div class="row">
                                            
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                                    <div class="left-form">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Your Name</label>
                                                            <input type="text" class="form-control" id="name" name="name"
                                                            value="<?php echo $_SESSION['username']; ?>" placeholder="customer's name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Your Email</label>
                                                            <input type="text" class="form-control" id="email" name= "email"
                                                            value="<?php echo $_SESSION['email']; ?>" placeholder="Your Email">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">User Id</label>
                                                            <input type="text" class="form-control" id="user_id" name= "user_id"
                                                            value="<?php echo $_SESSION['user_id']; ?>"   placeholder="user_id">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Special Request</label>
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" name="special_request"
                                                                placeholder="Your Message">
                                                        </div>                                             
                                                    </div>                            
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                                    <div class="right-form">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Your Number</label>
                                                            <input type="number" class="form-control" id="exampleFormControlInput1" name = "phonenumber"
                                                            value="<?php echo $_SESSION['phone']; ?>"  placeholder="customer's Number">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="select1" class="form-label">No of Person</label>
                                                            <select class="form-select" id="select1" name="select1">
                                                                <option value="1">Person 1</option>
                                                                <option value="2">Person 2</option>
                                                                <option value="3">Person 3</option>
                                                                <option value="4">Person 4</option>
                                                                <option value="5">Person 5</option>
                                                                <option value="6">Person 6</option>
                                                                <option value="7">Person 7</option>
                                                                <option value="8">Person 8</option>
                                                            </select>
                                                           
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Address</label>
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" name = "address"
                                                            value="<?php echo $_SESSION['address']; ?>"  placeholder="address">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Pick Up Time</label>
                                                            <input type="datetime-local" name ="time" class="form-control" name ="time" id="exampleFormControlInput1"
                                                                placeholder="Your Message">
                                                        </div>
                                                    </div>
                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center" style="padding-Bottom: 20px;">
                                        <button type="submit" name="submit" class="btn btn-outline-warning btn-lg">Submit</button>
                                    </div>
                                </div>                              
                            </form>        
                        </div>
                    
<!-- Gallery design -->
                        <div class="row" id="gallery">
                            <div class="col-lg-10 m-auto">
                                <div class="book-table-img-slider" id="icon">
                                    <div class="swiper-wrapper">
                                        <a href="assets/images/bt1.jpg" data-fancybox="table-slider"
                                            class="book-table-img back-img swiper-slide"
                                            style="background-image: url(assets/images/table1.jpg)"></a>
                                        <a href="assets/images/bt2.jpg" data-fancybox="table-slider"
                                            class="book-table-img back-img swiper-slide"
                                            style="background-image: url(assets/images/table\ 3.jpg)"></a>
                                        <a href="assets/images/bt3.jpg" data-fancybox="table-slider"
                                            class="book-table-img back-img swiper-slide"
                                            style="background-image: url(assets/images/table\ 5.webp)"></a>
                                        <a href="assets/images/bt4.jpg" data-fancybox="table-slider"
                                            class="book-table-img back-img swiper-slide"
                                            style="background-image: url(assets/images/table\ main.jpg)"></a>
                                      
                                        <a href="assets/images/bt2.jpg" data-fancybox="table-slider"
                                            class="book-table-img back-img swiper-slide"
                                            style="background-image: url(assets/images/table\ 5.webp)"></a>
                                      
                                    </div>

                                    <div class="swiper-button-wp">
                                        <div class="swiper-button-prev swiper-button">
                                            <i class="uil uil-angle-left"></i>
                                        </div>
                                        <div class="swiper-button-next swiper-button">
                                            <i class="uil uil-angle-right"></i>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </section> 
<?php require "includes/footer.php"; ?>