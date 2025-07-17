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

if(isset($_REQUEST['Delete'])){
$sql = "DELETE FROM booktable WHERE c_user_id = {$_SESSION['user_id']}";
                if($conn->query($sql) === TRUE){
                // echo "Record Deleted Successfully";
                // below code will refresh the page after deleting the record
                echo '<meta http-equiv="refresh" content= "0;URL=?closed" />';
                } else {
                    echo "Unable to Delete Data";
                }
            }


            // Delete
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM checkout WHERE id = $delete_id ") or die('query failed');
    if($delete_query){
    //    header('location:menuview.php');
       $message[] = 'product has been deleted';
    }else{
    //    header('location:menuview.php');
       $message[] = 'product could not be deleted';
    };
 };
?>

<style>
/* Add this to your existing styles or in a separate stylesheet */
.user-profile-box {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 20px 0;
    padding: 20px;
    text-align: center; /* Center text within the box */
    margin-top: 120px;
}

.profile-name {
    color: #333;
    margin-bottom: 10px;
}

.avatar {
    width: 100%;
    height: 150px;
    background-color: #ddd; /* Placeholder background color */
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}

.user-info {
    padding: 20px;
}

.user-info p {
    margin: 8px 0;
    color: #333;
    
}

.user-id {
    color: #777;
}

.message-box {
    background-color: #f2f2f2;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 20px 0;
    padding: 20px;
    text-align: center;
    margin-top:120px;
}

.message-box p {
    color: #333;
    margin: 8px 0;
}
h4{
    color:#097969;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <!-- User Profile Box -->
            <div class="user-profile-box">
            <?php 
                if(isset($_SESSION['username'])) : 
            ?>
                <h2 class="profile-name"><?php echo $_SESSION['username']; ?></h2>
                <div class="avatar">
                    <!-- Replace the src attribute with the actual path to the user's avatar -->
                    <img src="assets/images/profile.png" alt="User Avatar">
                </div>
                <div class="user-info">
                    <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                    <p><strong>Number:</strong> <?php echo $_SESSION['phone']; ?></p>
                    <p><strong>Address:</strong> <?php echo $_SESSION['address']; ?></p>
                    <p class="user-id"><strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?></p>

                    <?php endif; ?>
                </div>
            </div>
            <div class="message-box">
                <?php
                $id = $_SESSION['user_id'];
                $sql = "SELECT * FROM booktable WHERE c_user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<form action="" method="POST">';
                        echo '<div class="card mt-5 mx-5">';
                        echo '<div class="card-header">';
                        echo '<h4> Your Booking</h4>';
                        echo '<strong>Booking ID : </strong>' . $row['id'];
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title"><strong>User Id: </strong>' . $row['c_user_id'] . '</h5>';
                        echo '<p class="card-text"><strong>No of Person: </strong>' . $row['no_of_person'] . '</p>';
                        echo '<p class="card-text"><strong>Booking Date: </strong>' . $row['booking_date'] . '</p>';
                        echo '<p class="card-text"><strong>Booking Status: </strong>Pending..</p>';

                        echo '<div class="float-right">';
                        echo '<input type="hidden" name="c_user_id" value=' . $row["c_user_id"] . '>';
                        // echo '<input type="submit" class="btn btn-danger mr-2" name="view" value="View">';
                        echo '<input type="submit" class="btn btn-primary mr-2" name="Delete" value="Cancel Booking">';
                        // echo '<a href="user_profile.php?delete=' . $row['id'] . '" class="btn btn-primary ml-3" name="delete">Cancel Booking</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                    }
                } else {
                    echo '<div class="alert alert-info mt-5 col-sm-6" role="alert">
                            <h4 class="alert-heading">Reserve our table for any ocassion!</h4>
                          
                            <p>Enjoy and Stay with Us</p>
                            <hr>
                            <h5 class="mb-0">GrabOut</h5>
                        </div>';
                }
                $stmt->close();
                ?>
            </div>

            <div class="message-box">
                <?php
                $id = $_SESSION['user_id'];
                $sql = "SELECT * FROM confirm_tb WHERE c_user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<form action="" method="POST">';
                        echo '<div class="card mt-5 mx-5">';
                        echo '<div class="card-header">';
                        echo '<h4>Confirm Booking Table History</h4>';
                        echo '<strong>Booking ID : </strong>' . $row['id'];
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title"><strong>User Id: </strong>' . $row['c_user_id'] . '</h5>';
                        echo '<p class="card-text"><strong>No of Person: </strong>' . $row['no_of_person'] . '</p>';
                        echo '<p class="card-text"><strong>Booking Date: </strong>' . $row['booking_date'] . '</p>';
                        echo '<p class="card-text"><strong>Booking Status: </strong>' . $row['booking'] . '</p>';
                        echo '<div class="float-right">';
                        echo '<input type="hidden" name="c_user_id" value=' . $row["id"] . '>';
                        // echo '<input type="submit" class="btn btn-danger mr-2" name="view" value="View">';
                        // echo '<input type="submit" class="btn btn-primary mr-2" name="Delete" value="Cancel Booking">';
                        // echo '<a href="user_profile.php?delete=' . $row['id'] . '" class="btn btn-primary ml-3" name="delete">Cancel Booking</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                    }
                } else {
                    echo '<div class="alert alert-info mt-5 col-sm-6" role="alert">
                            <h4 class="alert-heading">Reserve our table for any ocassion!</h4>
                          
                            <p>Enjoy and Stay with Us</p>
                            <hr>
                            <h5 class="mb-0">GrabOut</h5>
                        </div>';
                }
                $stmt->close();
                ?>
            </div>
    



        </div>
        <div class="col-lg-6">
    <!-- Message Box -->
    <div class="message-box">
        <?php
        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM checkout WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<form action="" method="POST">';
                echo '<div class="card mt-5 mx-5">';
                echo '<div class="card-header">';
                echo '<h3> Your Order</h3>';
                echo '<strong>Order ID : </strong>' . $row['id'];
                echo '</div>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title"><strong>User ID : </strong>' . $row['user_id'] . '</h5>';
                echo '<p class="card-text"><strong>Total Products: </strong>' . $row['total_products'] . '</p>';
                echo '<p class="card-text"><strong>Total Price: </strong>' . $row['total_price'] . '</p>';
                echo '<p class="card-text"><strong>Order Date: </strong>' . $row['created_at'] . '</p>';
                echo '<p class="card-text"><strong>Order Status: </strong>Order Pending...</p>';

                // echo '<p class="card-text"><strong>Your Order is: </strong>' . $row['order_confirm'] . '</p>';
                echo '<div class="float-right">';
                echo '<input type="hidden" name="c_user_id" value=' . $row["user_id"] . '>';
                // echo '<input type="submit" class="btn btn-danger mr-2" name="view" value="View">';
                echo '<a href="user_profile.php?delete=' . $row['id'] . '" class="btn btn-danger ml-3" name="delete">Cancel Order</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</form>';
            }
        } else {
            echo '<div class="alert alert-info mt-5 col-sm-6" role="alert">
                    <h4 class="alert-heading">Order Your Food!</h4>
                 
                    <p>Enjoy and Stay with Us</p>
                    <hr>
                    <h5 class="mb-0">GrabOut</h5>
                </div>';
        }
        $stmt->close();
        ?>
    </div>

    <div class="message-box">
        <?php
        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM order_confirm_tb WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<form action="" method="POST">';
                echo '<div class="card mt-5 mx-5">';
                echo '<div class="card-header">';
                echo '<h3>Order Confirm History Details</h3>';
                echo '<strong>Order ID : </strong>' . $row['order_id'];
                echo '</div>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title"><strong>User ID : </strong>' . $row['user_id'] . '</h5>';
                echo '<p class="card-text"><strong>Total Products: </strong>' . $row['total_products'] . '</p>';
                echo '<p class="card-text"><strong>Total Price: </strong>' . $row['total_price'] . '</p>';
                echo '<p class="card-text"><strong>Order Date: </strong>' . $row['time_date'] . '</p>';
                echo '<p class="card-text"><strong>Order Status: </strong>' . $row['order_confirm'] . '</p>';

                // echo '<p class="card-text"><strong>Your Order is: </strong>' . $row['order_confirm'] . '</p>';
                echo '<div class="float-right">';
                echo '<input type="hidden" name="c_user_id" value=' . $row["user_id"] . '>';
                // echo '<input type="submit" class="btn btn-danger mr-2" name="view" value="View">';
                // echo '<a href="user_profile.php?delete=' . $row['id'] . '" class="btn btn-danger ml-3" name="delete">Cancel Order</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</form>';
            }
        } else {
            echo '<div class="alert alert-info mt-5 col-sm-6" role="alert">
                    <h4 class="alert-heading">Order Your Food!</h4>
                 
                    <p>Enjoy and Stay with Us</p>
                    <hr>
                    <h5 class="mb-0">GrabOut</h5>
                </div>';
        }
        $stmt->close();
        ?>
    </div>
</div>

<?php require "includes/footer.php"; ?>