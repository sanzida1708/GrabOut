<?php
include('Admin/header.php');
require "config/config.php";
require "libs/App.php";

$hostname = "localhost";
$username = "root";
$password = "";
$database = "grabout";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM order_confirm_tb WHERE id = $delete_id ") or die('query failed');
    if ($delete_query) {
        $message[] = 'product has been deleted';
    } else {
        $message[] = 'product could not be deleted';
    };
}
?>

<style>

  .form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    margin-left: 300px;
    margin-top: 80px;
  }

  .form-container form {
    width: 100%;
  }

  .form-group span,
  .form-group .btn {
    margin-left: 30px;
    margin:10px;
  }

  .custom-table-margin {
    margin-left: 80px;
  }

  .centered-text {
    text-align: center;
  }

  .bg-dark-left {
    margin-left: 170px; /* Adjust the value as needed */
  }
  

</style>

<div class="col-sm-9 col-md-10 mt-5 text-center">
  <div class="form-container">
    <form action="" method="POST" class="d-print-none">
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="startdate" class="visually-hidden">Start Date</label>
          <input type="date" class="form-control" id="startdate" name="startdate" placeholder="Start Date">
        </div>
        <div class="form-group col-md-3">
          <label for="enddate" class="visually-hidden">End Date</label>
          <span> to </span>
          <input type="date" class="form-control" id="enddate" name="enddate" placeholder="End Date">
        </div>
        <div class="form-group col-md-3">
          <button type="submit" class="btn btn-secondary" name="searchsubmit">Search</button>
        </div>
      </div>
    </form>
  </div>

  <?php
  if (isset($_REQUEST['searchsubmit'])) {
      $startdate = $_REQUEST['startdate'];
      $enddate = $_REQUEST['enddate'];
      $sql = "SELECT * FROM order_confirm_tb WHERE time_date BETWEEN '$startdate' AND '$enddate'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          echo '
        <p class=" bg-dark text-white p-2 mt-8 centered-text bg-dark-left">Details</p>
        <table class="table custom-table-margin">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer name</th>
                    <th scope="col">Customer ID</th>
                    <th scope="col">Customer Address</th>
                    <th scope="col">Order Items</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Date & Time</th>
                    
                </tr>
            </thead>
            <tbody>';
          while ($row = $result->fetch_assoc()) {
              echo '<tr>
                    <th scope="row">' . $row["order_id"] . '</th>
                    <td>' . $row["name"] . '</td>
                    <td>' . $row["user_id"] . '</td>
                    <td>' . $row["address"] . '</td>
                    <td>' . $row["total_products"] . '</td>
                    <td>' . $row["total_price"] . '</td>
                    <td>' . $row["time_date"] . '</td>
                  
                </tr>';
          }
          echo '<tr>
                <td>
                    <form class="d-print-none">
                        <input class="btn btn-danger" type="submit" value="Print" onClick="window.print()">
                    </form>
                </td>
            </tr></tbody>
        </table>';
      } else {
          echo "<div class='alert alert-warning col-sm-6 ml-5 mt-2' role='alert'> No Records Found ! </div>";
      }
  }
  ?>
</div>

<?php
include('Admin/footer.php');
?>
