<?php
require "config/config.php";
require "libs/App.php";
require "includes/header.php";

$hostname = "localhost";
$username = "root";
$password = "";
$database = "grabout";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['order_btn'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $user_id = $_POST['user_id']; // Assuming this value is passed in the form
    $method = $_POST['method'];
    $address = $_POST['location'];

    $cart_query = mysqli_query($conn, "SELECT * FROM addcart WHERE user_id = '$user_id'");
    $price_total = 0;
    $product_name = [];

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name[] = $product_item['name'] . ' (' . $product_item['quantity'] . ') ';
            $price_total += $product_item['price'] * $product_item['quantity'];
        }
    }

    $total_product = implode(', ', $product_name);
    $detail_query = mysqli_query($conn, "INSERT INTO checkout (name, number, email, user_id, payment_method, Address, total_products, total_price) VALUES('$name','$number','$email','$user_id','$method','$address','$total_product','$price_total')") or die('query failed');

    if ($detail_query) {
        echo "
        <div class='order-message-container'>
            <div class='message-container'>
                <h3>Thank you for shopping! <br> Stay With GrabOut</h3>
                <div class='order-detail'>
                    <span>" . $total_product . "</span>
                    <span class='total'> Total: $" . $price_total . "/-</span>
                </div>
                <div class='customer-details'>
                    <p>Your name: <span>" . $name . "</span></p>
                    <p>Your number: <span>" . $number . "</span></p>
                    <p>Your email: <span>" . $email . "</span></p>
                    <p>Your address: <span>" . $address . "</span></p>
                    <p>Your payment mode: <span>" . $method . "</span></p>
                    <p>(*Pay when product arrives*)</p>
                </div>
                <a href='menu.php' class='btn'>Continue Shopping</a>
            </div>
        </div>
        ";
    }
}
?>

 

<style>

.order-message-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 600px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    z-index: 9999; /* Ensure it appears on top of everything */
}

.message-container {
    text-align: center;
}

.message-container h3 {
    font-size: 24px;
    color: orange;
    margin-bottom: 20px;
}

.order-detail span {
    display: block;
    font-size: 18px;
    margin-bottom: 10px;
    color: orange;
}

.total {
    font-size: 20px;
    font-weight: bold;
    color: #fcbc30;
    margin-top: 10px;
}

.customer-details p {
    font-size: 16px;
    margin-bottom: 10px;
}

.btn {
    background-color: orange;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #d67b00;
}




.checkout-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    margin-top:130px;
}

.checkout-form {
    text-align: center;
    background-color: #444444;
    border-radius: 15px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    padding: 40px;
}


.heading {
    font-size: 36px;
    color: orange;
    margin-bottom: 20px;
}

.display-order {
    margin: 30px 0;
}

.display-order span {
    display: block;
    font-size: 18px;
    margin-bottom: 10px;
    color: orange;
}

.grand-total {
    font-size: 24px;
    font-weight: bold;
    color: #fcbc30;
}

.flex {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.inputBox {
    flex: 0 0 48%;
    margin-bottom: 20px;
}

.inputBox span {
    display: block;
    font-size: 16px;
    color: orange;
    margin-bottom: 8px;
}

input, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.btn {
    background-color: #fcbc30;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #d6a029;
}
.order-summary {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.display-order {
    /* Your existing styles for display-order */
}

.grand-total {
    display: block;
    margin-top: 10px;
    font-size: 18px;
    font-weight: bold;
    color: orange;
}
</style>

<div class="container checkout-container">
    <section class="checkout-form">
        <h1 class="heading">Complete Your Order</h1>
        <form action="" method="post">
            <div class="order-summary">
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM addcart WHERE user_id = '$user_id'");
                $total = 0;
                $grand_total = 0;
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                        $grand_total = $total += (float)$total_price;
                        ?>
                        <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
                <?php
                    }
                } else {
                    echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                }
                ?>
                <span class="grand-total">Grand Total: $<?= $grand_total; ?>/-</span>
            </div>
            <div class="flex">
                <div class="inputBox">
                    <span>Name</span>
                    <input type="text" value="<?php echo $_SESSION['username']; ?>" name="name" required>
                </div>
                <div class="inputBox">
                    <span>Number</span>
                    <input type="phone_number" value="<?php echo $_SESSION['phone']; ?>" name="number" required>
                </div>
                <div class="inputBox">
                    <span>Email</span>
                    <input type="email" value="<?php echo $_SESSION['email']; ?>" name="email" required>
                </div>
                <div class="inputBox">
                    <span>User Id</span>
                    <input type="user_id" value="<?php echo $_SESSION['user_id']; ?>" name="user_id" readonly>
                </div>
                <div class="inputBox">
                    <span>Payment Method</span>
                    <select name="method">
                        <option value="cash on delivery" selected>cash on delivery</option>
                        <option value="bkash">Bkash</option>
                        <option value="nagad">Nagad</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Address</span>
                    <input type="text" value="<?php echo $_SESSION['address']; ?>" name="location" required>
                </div>
            </div>
            <input type="submit" value="Order Now" name="order_btn" class="btn">
        </form>
    </section>
</div>

<?php require "includes/footer.php"; ?>


<script>
    function submitForm() {
        document.getElementById("orderForm").submit();
    }
</script>
