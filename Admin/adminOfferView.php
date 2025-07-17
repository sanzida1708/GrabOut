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
    $delete_query = mysqli_query($conn, "DELETE FROM offer_item WHERE id = $delete_id ") or die('query failed');
    if($delete_query){
    //    header('location:menuview.php');
       $message[] = 'product has been deleted';
    }else{
    //    header('location:menuview.php');
       $message[] = 'product could not be deleted';
    };
 };
//  Update
 if(isset($_POST['update_product'])){
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_name'];
    $update_start = $_POST['update_startdate'];
    $update_enddate = $_POST['update_enddate'];
    $update_description = $_POST['update_description'];
    $update_p_regularprice = $_POST['update_p_regularprice'];
    $update_p_offerprice = $_POST['update_p_offerprice'];
    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = 'offer_image/'.$update_p_image;
 
    $update_query = mysqli_query($conn, "UPDATE offer_item SET foodName = '$update_p_name', startdate='$update_start', enddate='$update_enddate', description= '$update_description', regularprice = '$update_p_regularprice', offerprice = '$update_p_offerprice', foodImage = '$update_p_image' WHERE id = '$update_p_id'");
 
    if($update_query){
       move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
       $message[] = 'product updated succesfully';
    //    header('location:menuview.php');
    }else{
       $message[] = 'product could not be updated';
    //    header('location:menuview.php');
    }
 
 }
 
 ?>
?>
 <!-- custom css  -->
 <link rel="stylesheet" href="adminstyle.css">
<div class="container">
<section class="display-product-table">

   <table>

      <thead>
         <th>Food image</th>
         <th>Food name</th>
         <th>Start Date</th>
         <th>End Date</th>
         <th>Description</th>
         <th>Regular price</th>
         <th>Offer price</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM offer_item ");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><img src="offer_image/<?php echo $row['foodImage']; ?>" height="100" alt=""></td>
            <td><?php echo $row['foodName']; ?></td>
            <td><?php echo $row['startdate']; ?></td>
            <td><?php echo $row['enddate']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['regularprice']; ?>Tk/-</td>
            <td><?php echo $row['offerprice']; ?>Tk/-</td>
            <td>
               <a href="adminOfferView.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i>Delete </a>
               <a href="adminOfferView.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i>Update </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM offer_item WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="offer_image/<?php echo $fetch_edit['foodImage']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['foodName']; ?>">
      <input type="text" class="box" required name="update_enddate" value="<?php echo $fetch_edit['startdate']; ?>">
      <input type="text" class="box" required name="update_startdate" value="<?php echo $fetch_edit['enddate']; ?>">
      <input type="text" class="box" required name="update_description" value="<?php echo $fetch_edit['description']; ?>">
      <input type="text" min="0" class="box" required name="update_p_regularprice" value="<?php echo $fetch_edit['regularprice']; ?>">
      <input type="text" min="0" class="box" required name="update_p_offerprice" value="<?php echo $fetch_edit['offerprice']; ?>">
      <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the prodcut" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-edit" class="option-btn">
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

</div>

<?php
include('Admin/footer.php'); 
?>

<script>
document.querySelector('#close-edit').onclick = () =>{
   document.querySelector('.edit-form-container').style.display = 'none';
   window.location.href = 'adminOfferView.php';
};
    </script>