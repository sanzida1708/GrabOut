<?php require "config/config.php"; ?>
<?php require "libs/App.php"; ?>
<?php require "includes/header.php"; ?>

<?php

$query = "SELECT * FROM menu WHERE mealType = 1 ";
$app = new App;
$meals_1 = $app->selectAll($query);

$query = "SELECT * FROM menu WHERE mealType = 2 ";
$app = new App;
$meals_2 = $app->selectAll($query);

$query = "SELECT * FROM menu WHERE mealType = 3 ";
$app = new App;
$meals_3 = $app->selectAll($query);


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

// Set the user-specific cart table name
$user_id = $_SESSION['user_id'];
$cart_table = "addcart";

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['foodName'];
    $product_image = $_POST['foodImage'];
    $product_price = $_POST['price'];
    $product_user_id = $_SESSION['user_id'];
    $product_quantity = 1;
    $product_foodid = $_POST['food_id'];

    // Check if the product is already in the cart for the user
    $existing_product_query = mysqli_query($conn, "SELECT * FROM $cart_table WHERE food_id = '$product_foodid' AND user_id = '$product_user_id'");

    if (mysqli_num_rows($existing_product_query) > 0) {
        $message[] = 'Product already added to cart';
    } else {
        // Insert the product into the cart
        $insert_product = mysqli_query($conn, "INSERT INTO $cart_table (name, image, price, user_id, quantity, food_id) VALUES ('$product_name', '$product_image', '$product_price', '$product_user_id', '$product_quantity', '$product_foodid')");

        if ($insert_product) {
            $message[] = 'Product added to cart successfully';
        } else {
            $message[] = 'Failed to add product to cart';
        }
    }
}

?>


<!-- Menu -->
<section style="background-image: url(assets/images/menu-bg.png);"
    class="our-menu section repeat-img" id="menu">
    <div class="sec-wp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sec-title text-center mb-5">
                        <p class="sec-sub-title mb-3">our menu</p>
                        <h2 class="h2-title">wake up early, <span>eat fresh & healthy</span></h2>
                        <div class="sec-title-shape mb-4">
                            <img src="assets/images/title-shape.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-tab-wp">
                <div class="row">
                    <div class="col-lg-12 m-auto">
                        <div class="menu-tab text-center">
                            <ul class="filters">
                                <div class="filter-active"></div>
                                <li class="filter" data-filter=".all,.breakfast,.lunch,.dinner">
                                    <img src="assets/images/menu-1.png" alt="">
                                    All
                                </li>
                                <li class="filter" data-filter=".breakfast">
                                    <img src="assets/images/menu-2.png" alt="">
                                    Fastfood
                                </li>
                                <li class="filter" data-filter=".lunch">
                                    <img src="assets/images/menu-3.png" alt="">
                                    Dessert
                                </li>
                                <li class="filter" data-filter=".dinner">
                                    <img src="assets/images/menu-4.png" alt="">
                                    Set menu
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu-list-row">
                <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                    <?php foreach($meals_1 as $meal_1) : ?>
                        <div class="col-lg-4 col-sm-6 dish-box-wp breakfast" data-cat="breakfast">
                            <div class="dish-box text-center">
                                <div class="dist-img">
                                    <img src="assets/images/<?php echo $meal_1->foodImage; ?>" alt="">
                                </div>
                                <!-- <div class="dish-rating">
                                    4.7
                                    <i class="uil uil-star"></i>
                                </div> -->
                                <div class="dish-title">
                                    <h3 class="h3-title"> <?php echo $meal_1->foodName; ?> </h3>

                                    <!-- <p> Code_id:<php echo $meal_2->id; ?> <br><php echo $meal_2->description; ?></p> -->

                                    <p>Code_id:<?php echo $meal_1->id; ?> <br> <?php echo $meal_1->description; ?></p>
                                </div>

                                <div class="dist-bottom-row">
                                    <ul>
                                        <li>
                                            <b> <?php echo $meal_1->price; ?> Tk.</b>
                                        </li>
                                        <li>
                                            <!-- Add a form tag around the button -->
                                            <form method="post" action="">
                                                <!-- Include the necessary hidden input fields -->
                                                <input type="hidden" name="foodName" value="<?php echo $meal_1->foodName; ?>">
                                                <input type="hidden" name="foodImage" value="<?php echo $meal_1->foodImage; ?>">
                                                <input type="hidden" name="price" value="<?php echo $meal_1->price; ?>">
                                                <input type="hidden" name="food_id" value="<?php echo $meal_1->id; ?>">
                                                <!-- Change the button type to submit -->
                                                <button type="submit" name="add_to_cart" class="dish-add-btn">
                                                    <i class="uil uil-plus"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php foreach($meals_2 as $meal_2) : ?>
                        <div class="col-lg-4 col-sm-6 dish-box-wp lunch" data-cat="lunch">
                            <div class="dish-box text-center">
                                <div class="dist-img">
                                    <img src="assets/images/<?php echo $meal_2->foodImage; ?>" alt="">
                                </div>
                                <!-- <div class="dish-rating">
                                    4.7
                                    <i class="uil uil-star"></i>
                                </div> -->
                                <div class="dish-title">
                                    <h3 class="h3-title"> <?php echo $meal_2->foodName; ?> </h3>
                                    
                                    <!-- <p> Code_id:<php echo $meal_2->id; ?> <br><php echo $meal_2->description; ?></p> -->
                                    <p>Code_id:<?php echo $meal_2->id; ?> <br><?php echo $meal_2->description; ?></p>

                                </div>

                                <div class="dist-bottom-row">
                                    <ul>
                                        <li>
                                            <b> <?php echo $meal_2->price; ?> Tk.</b>
                                        </li>
                                        <li>
                                            <!-- Add a form tag around the button -->
                                            <form method="post" action="">
                                                <!-- Include the necessary hidden input fields -->
                                                <input type="hidden" name="foodName" value="<?php echo $meal_2->foodName; ?>">
                                                <input type="hidden" name="foodImage" value="<?php echo $meal_2->foodImage; ?>">
                                                <input type="hidden" name="price" value="<?php echo $meal_2->price; ?>">
                                                <input type="hidden" name="food_id" value="<?php echo $meal_2->id; ?>">

                                               

                                                <!-- Change the button type to submit -->
                                                <button type="submit" name="add_to_cart" class="dish-add-btn">
                                                    <i class="uil uil-plus"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>


                    <?php foreach($meals_3 as $meal_3) : ?>
                        <div class="col-lg-4 col-sm-6 dish-box-wp dinner" data-cat="dinner">
                            <div class="dish-box text-center">
                                <div class="dist-img">
                                    <img src="assets/images/<?php echo $meal_3->foodImage; ?>" alt="">
                                </div>
                                <!-- <div class="dish-rating">
                                    4.7
                                    <i class="uil uil-star"></i>
                                </div> -->
                                <div class="dish-title">
                                    <h3 class="h3-title"> <?php echo $meal_3->foodName; ?> </h3>
                                   
                                    <!-- <p> Code_id:<php echo $meal_2->id; ?> <br><php echo $meal_2->description; ?></p> -->

                                    <p>Code_id:<?php echo $meal_3->id; ?> <br><?php echo $meal_3->description; ?></p>

                                </div>

                                <div class="dist-bottom-row">
                                    <ul>
                                        <li>
                                            <b> <?php echo $meal_3->price; ?> Tk.</b>
                                        </li>
                                        <li>
                                            <!-- Add a form tag around the button -->
                                            <form method="post" action="">
                                                <!-- Include the necessary hidden input fields -->
                                                <input type="hidden" name="foodName" value="<?php echo $meal_3->foodName; ?>">
                                                <input type="hidden" name="foodImage" value="<?php echo $meal_3->foodImage; ?>">
                                                <input type="hidden" name="price" value="<?php echo $meal_3->price; ?>">
                                                <input type="hidden" name="food_id" value="<?php echo $meal_3->id; ?>">

                                      
                                                <!-- Change the button type to submit -->
                                                <button type="submit" name="add_to_cart" class="dish-add-btn">
                                                    <i class="uil uil-plus"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

              

                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function showMessage(message) {
        // Create a div element for the message box
        var messageBox = document.createElement('div');
        messageBox.innerHTML = message;
        messageBox.style.position = 'fixed';
        messageBox.style.top = '50%';
        messageBox.style.left = '50%';
        messageBox.style.transform = 'translate(-50%, -50%)';
        messageBox.style.background = '#fff';
        messageBox.style.padding = '20px';
        messageBox.style.boxShadow = '0 0 10px rgba(0, 0, 0, 0.3)';
        messageBox.style.zIndex = '9999';

        // Create an OK button to close the message box
        var okButton = document.createElement('button');
        okButton.innerHTML = 'OK';
        okButton.style.padding = '15px';
        okButton.style.marginTop = '20px';
        okButton.style.marginLeft = '20px';
        okButton.style.cursor = 'pointer';
        okButton.style.border = 'none';
        okButton.style.background = '#FFA500';
        okButton.style.color = '#fff';
        okButton.style.borderRadius = '10px';

        // Append the OK button to the message box
        messageBox.appendChild(okButton);

        // Append the message box to the body
        document.body.appendChild(messageBox);

        // Add a click event listener to the OK button to remove the message box
        okButton.addEventListener('click', function() {
            document.body.removeChild(messageBox);
        });
    }

    // Check if there are messages and show them
    <?php
    foreach ($message as $msg) {
        echo "showMessage('$msg');";
    }
    ?>
</script>


<?php require "includes/footer.php"; ?>
