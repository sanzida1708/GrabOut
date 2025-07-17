<?php require "config/config.php"; ?>
<?php require "libs/App.php"; ?>
<?php require "includes/header.php"; ?>

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

// Update cart item quantity
if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE addcart SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      // header('location:add-cart.php');
   }
}

// Remove a specific item from the cart (for a specific user)
if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM addcart WHERE id = '$remove_id' AND user_id = '{$_SESSION['user_id']}'");
   // header('location:add-cart.php');
}

// Delete all items from the cart (for a specific user)
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM addcart WHERE user_id = '{$_SESSION['user_id']}'");
   // header('location:add-cart.php');
}

// Fetch cart items for the current user
$select_cart = mysqli_query($conn, "SELECT * FROM addcart WHERE user_id = '{$_SESSION['user_id']}'");
?>
 <!-- custom css  -->
 <style>
    /* Shopping Cart Styles */

    
    .shopping-cart {
        margin-top: 100px;
        text-align: center;
    }

    .heading {
        font-size: 36px;
        color: var(--third-color);
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: var(--fifth-color);
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
        color: white;
    }

    th {
        background-color: #222222;
    }


    tbody tr:hover {
        background-color: #222222;
    }


    .delete-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #f44336; /* Red color, you can change it */
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
        background-color: #d32f2f; /* Darker red color on hover */
        text-decoration: none;
    }

    /* Style for the trash icon */
    .delete-btn i {
        margin-right: 5px;
    }


    input[name="update_update_btn"] {
        display: inline-block;
        padding: 10px 20px;
        background-color: #FFA500; 
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[name="update_update_btn"]:hover {
        background-color: #FF4500; 
    }


    .image-column img {
        max-width: 80px;
        max-height: 80px;
        border-radius: 5px;
        display: inline-block;
    }

    .quantity-column input {
        width: 50px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .total-price-column {
        font-weight: bold;
    }

    .action-column a {
        color: #fff;
        text-decoration: none;
        padding: 8px 12px;
        background-color: #ff4343;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .action-column a:hover {
        background-color: #ff2a2a;
        text-decoration: none;
    }

    .checkout-btn {
        margin-top: 20px;
        margin-bottom:20px;
    }

    .checkout-btn a {
      display: block;
      width: 100%;
      text-align: center;
      font-size: 1rem;
      padding: 1rem 1rem;
      border-radius: .5rem;
      cursor: pointer;
      color: var(--white);
      margin-top: 1rem;
      background-color: #2980b9;
    }
    .checkout-btn a:hover{
      filter: brightness(120%);
      /* background-color: #ff2a2a; */
    }

    .checkout-btn a.disabled {
        background-color: #ccc;
        pointer-events: none;
    }

    .table-bottom{
      background-color:gray;
    }

    .table-bottom:hover{
      background-color:gray;
    }

    .table-bottom .option-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: 	#FFA500; 
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .table-bottom .option-btn:hover {
        background-color: #FF6347; /* Darker green color on hover */
        text-decoration: none;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .heading {
            font-size: 28px;
        }

        table {
            font-size: 14px;
        }

        .quantity-column input {
            width: 40px;
            padding: 6px;
        }
    }

    /* Add more responsive styles as needed */
</style>

<div class="container">

    <section class="shopping-cart">
        <h1 class="heading">Shopping Cart</h1>
        <table>
            <thead>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) :
                    ?>
                    <tr>
                        <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['name']; ?></td>
                        <td><?php echo number_format($fetch_cart['price']); ?>Tk/-</td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['id']; ?>" >
                                <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['quantity']; ?>" >
                                <input type="submit" value="Update" name="update_update_btn">
                            </form>   
                        </td>
                        <td><?php
                            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                            echo number_format($sub_total) . "Tk/-";
                            ?></td>
                        <td><a href="add-cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a></td>
                    </tr>
                    <?php
                    // Check if $sub_total is numeric before adding
                    if (is_numeric($sub_total)) {
                        $grand_total += $sub_total;
                    }
                endwhile;
                ?>
                <tr class="table-bottom">
                    <td><a href="menu.php" class="option-btn" style="margin-top: 0;">Continue Shopping</a></td>
                    <td colspan="3">Total Bill</td>
                    <td><?php echo $grand_total; ?>Tk/-</td>
                    <td><a href="add-cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> Delete All </a></td>
                </tr>
            </tbody>
        </table>
        <div class="checkout-btn">
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
        </div>
    </section>

</div>

<?php require "includes/footer.php"; ?>