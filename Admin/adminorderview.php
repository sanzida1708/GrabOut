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



?>

<!-- Added some basic CSS styles for better presentation -->
<style>
    .left-section {
        float: left;
        width: 50%;
    }

    .right-section {
        float: right;
        width: 50%;
        background-color: #333;
        color: #fff;
        padding: 20px;
        margin-top: 50px;
        box-sizing: border-box;
    }

    .right-section label {
        color: #fff;
    }

    .right-section .form-control {
        background-color: #555;
        color: #fff;
    }

    .right-section button {
        margin-top: 10px;
    }
</style>

<div class="container">
    <div class="row">
        <!-- Left side content -->
        <div class="left-section">
            <div class="col-sm-12 mb-5">
                <?php
                $sql = "SELECT id , user_id, payment_method, total_price FROM checkout";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<form action="" method="POST">';
                        echo '<div class="card mt-5 mx-5">';
                        echo '<div class="card-header">';
                        echo 'Order ID : ' . $row['id'];
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Customer ID : ' . $row['user_id'] . '</h5>';
                        echo '<p class="card-text">Payment Method: ' . $row['payment_method'] . '</p>';
                        echo '<p class="card-text">Total Price: ' . $row['total_price'] . '</p>';
                        echo '<div class="float-right">';
                        echo '<input type="hidden" name="id" value=' . $row["id"] . '>';                     
                        echo '<input type="submit" class="btn btn-danger mr-2" name="view" value="View">';
                        // echo '<input type="submit" class="btn btn-primary ml-3" name="Delete" value="Delete">';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                    }
                } else {
                    echo '<div class="alert alert-info mt-5 col-sm-6" role="alert">
                            <h4 class="alert-heading">Well done!</h4>
                            <p>Aww yeah, you successfully assigned all Requests.</p>
                            <hr>
                            <h5 class="mb-0">No Pending Requests</h5>
                        </div>';
                }
                ?>
            </div>
        </div>



        

<?php
include('adminorderconfirm.php');
include('Admin/footer.php'); 
?>