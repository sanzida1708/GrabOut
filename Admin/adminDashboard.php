<?php
include('Admin/header.php'); 

// Check if the connection is successful
$hostname = "localhost";
$username = "root";
$password = "";
$database = "grabout";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$select_rows = mysqli_query($conn, "SELECT * FROM users");
$row_count = mysqli_num_rows($select_rows);
?>
<div class="col-sm-9 col-md-10">
  <div class="row mx-5 text-center">
    <div class="col-sm-4 mt-5">
      <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
        <div class="card-header">Total Users</div>
        <div class="card-body">
          <h4 class="card-title">
          <?php echo $row_count; ?>
          </h4>
          <!-- <a class="btn text-white" href="request.php">View</a> -->
        </div>
      </div>
    </div>
    <div class="col-sm-4 mt-5">
      <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header">Total Confirmed Order</div>
        <div class="card-body">
          <h4 class="card-title">
            <?php
            $select = mysqli_query($conn, "SELECT * FROM order_confirm_tb");
            $row_counts = mysqli_num_rows($select);
            ?>
           <?php echo $row_counts; ?>
          </h4>
          <!-- <a class="btn text-white" href="work.php">View</a> -->
        </div>
      </div>
    </div>
    <div class="col-sm-4 mt-5">
      <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
        <div class="card-header">Total Table Booking</div>
        <div class="card-body">
          <h4 class="card-title">
          <?php
            $select = mysqli_query($conn, "SELECT * FROM confirm_tb");
            $row_counts = mysqli_num_rows($select);
            ?>
             <?php echo $row_counts; ?>
          </h4>
          <!-- <a class="btn text-white" href="technician.php">View</a> -->
        </div>
      </div>
    </div>
  </div>
  <div class="mx-5 mt-5 text-center">
  
    <p class=" bg-dark text-white p-2">List of Users</p>

    <?php
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
 echo '<table class="table">
  <thead>
   <tr>
    <th scope="col">User ID</th>
    <th scope="col">Name</th>
    <th scope="col">Email</th>
   </tr>
  </thead>
  <tbody>';
  while($row = $result->fetch_assoc()){
   echo '<tr>';
    echo '<th scope="row">'.$row["id"].'</th>';
    echo '<td>'. $row["username"].'</td>';
    echo '<td>'.$row["email"].'</td>';
  }
 echo '</tbody>
 </table>';
} else {
  echo "0 Result";
}
?>
    
  </div>
</div>


<?php
include('Admin/footer.php'); 
?>