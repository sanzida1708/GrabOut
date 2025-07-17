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


// Delete
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM order_confirm_tb WHERE id = $delete_id ") or die('query failed');
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
    .display-product-table {
        margin-top: 80px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #333;
        color: #fff;
    }

    tbody tr:hover {
        background-color: #f5f5f5;
    }

    .delete-btn {
        color: #fff;
        background-color: #ff5252;
        text-decoration: none;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 4px;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .delete-btn:hover {
        background-color: #ff6347; /* Tomota Orange */
        /* text-decoration: underline; */
    }

    .empty {
        text-align: center;
        padding: 20px;
        color: #555;
    }
</style>
 <!-- custom css  -->
 <!-- <link rel="stylesheet" href="adminstyle.css"> -->
<div class="container">
<section class="display-product-table">

   <table>

      <thead>
         <th>Order ID</th>
         <th>Customer name</th>
         <th>Customer ID</th>
         <th>Customer Address</th>
         <th>Order Items</th>
         <th>Total Cost</th>
         <th>Date & Time</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM order_confirm_tb ");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
        
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['total_products']; ?></td>
            <td><?php echo $row['total_price']; ?>Tk/-</td>
            <td><?php echo $row['time_date']; ?></td>
            <td>
               <a href="adminorderconfirmlist.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>

            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no order added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

</div>







<?php

include('Admin/footer.php'); 
?>