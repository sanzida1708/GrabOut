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
    $delete_query = mysqli_query($conn, "DELETE FROM menu WHERE id = $delete_id ") or die('query failed');
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
    $update_mealType = $_POST['update_mealtype'];
    $update_description = $_POST['update_description'];
    $update_p_price = $_POST['update_p_price'];
    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = 'uploaded_img/'.$update_p_image;
 
    $update_query = mysqli_query($conn, "UPDATE menu SET foodName = '$update_p_name', mealType='$update_mealType', description= '$update_description', price = '$update_p_price', foodImage = '$update_p_image' WHERE id = '$update_p_id'");
 
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
         <th>Food MealType</th>
         <th>Food description</th>
         <th>Food price</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM menu ");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $row['foodImage']; ?>" height="100" alt=""></td>
            <td><?php echo $row['foodName']; ?></td>
            <td><?php echo $row['mealType']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['price']; ?>Tk/-</td>
            <td>
               <a href="menuview.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
               <a href="menuview.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
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
      $edit_query = mysqli_query($conn, "SELECT * FROM menu WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['foodImage']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['foodName']; ?>">
      <input type="number" class="box" required name="update_mealtype" value="<?php echo $fetch_edit['mealType']; ?>">
      <input type="text" class="box" required name="update_description" value="<?php echo $fetch_edit['description']; ?>">
      <input type="text" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
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
   window.location.href = 'menuview.php';
};
    </script>