<?php
// include('Admin/header.php');
// require "config/config.php";
// require "libs/App.php";

// // Check if the connection is successful
// $hostname = "localhost";
// $username = "root";
// $password = "";
// $database = "grabout";

// $conn = mysqli_connect($hostname, $username, $password, $database);

// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Check if the "View" button is clicked
if (isset($_POST['view'])) {
    if (isset($_POST['c_user_id'])) {
        $c_user_id = $_POST['c_user_id'];
        $sql = "SELECT * FROM booktable WHERE c_user_id = $c_user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
    } else {
        // Handle the case where c_user_id is not set
    }
}


//  Assign work Order Request Data going to submit and save on db assignwork_tb table
if(isset($_REQUEST['assign'])){
    // Checking for Empty Fields
    if(($_REQUEST['id'] == "") || ($_REQUEST['no_of_person'] == "") || ($_REQUEST['special_request'] == "") || ($_REQUEST['c_name'] == "") || ($_REQUEST['c_address'] == "") || ($_REQUEST['c_email'] == "") || ($_REQUEST['c_phonenumber'] == "") || ($_REQUEST['booking_date'] == "") || ($_REQUEST['booking'] == "")){
     // msg displayed if required field missing
     $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
    } else {
      // Assigning User Values to Variable
      $rid = $_REQUEST['id'];
      $rinfo = $_REQUEST['no_of_person'];
      $rdesc = $_REQUEST['special_request'];
      $rname = $_REQUEST['c_name'];
      $ruserid = $_REQUEST['c_user_id'];
      $radd = $_REQUEST['c_address'];
      $remail = $_REQUEST['c_email'];
      $rmobile = $_REQUEST['c_phonenumber'];
      $rdate = $_REQUEST['booking_date'];
      $rassigntech = $_REQUEST['booking'];
      $sql = "INSERT INTO confirm_tb (book_id, no_of_person, special_request, c_name,c_user_id, c_address, c_email, c_phonenumber, booking_date, booking) VALUES ('$rid', '$rinfo','$rdesc', '$rname', '$ruserid', '$radd', '$remail', '$rmobile', '$rdate', '$rassigntech')";
       if($conn->query($sql) == TRUE){
       // below msg display on form submit success
       $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Booking Confirmed Successfully </div>';
       // after assigning work we will delete data from submitrequesttable by pressing close button
            
        $sql = "DELETE FROM booktable WHERE id = {$_REQUEST['id']}";
                if($conn->query($sql) === TRUE){
                // echo "Record Deleted Successfully";
                // below code will refresh the page after deleting the record
                echo '<meta http-equiv="refresh" content= "0;URL=?closed" />';
                } else {
                    echo "Unable to Delete Data";
                }
                
            } else {
       // below msg display on form submit failed
       $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Confirmed </div>';
      }
    }
    }
   // Assign work Order Request Data going to submit and save on db assignwork_tb table [END]
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

<!-- Right side form -->
<div class="right-section">
            <div class="col-sm-12 mt-5 jumbotron">
                <form action="" method="POST">
                    <h5 class="text-center">Assign Booking Order Request</h5>
                    <div class="form-group">
                        <label for="id">Booking ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="<?php if (isset($row['id'])) {echo $row['id'];} ?>"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="no_of_person">Person</label>
                        <input type="text" class="form-control" id="no_of_person" name="no_of_person" value="<?php if (isset($row['no_of_person'])) {echo $row['no_of_person'];} ?>">
                    </div>
                    <div class="form-group">
                        <label for="special_request">Special Request</label>
                        <input type="text" class="form-control" id="special_request" name="special_request" value="<?php if (isset($row['special_request'])) { echo $row['special_request'];} ?>">
                    </div>
                    <div class="form-group">
                        <label for="c_name">Customer Name</label>
                        <input type="text" class="form-control" id="c_name" name="c_name" value="<?php if (isset($row['c_name'])) { echo $row['c_name'];} ?>">
                    </div>

                    <div class="form-group">
                        <label for="c_user_id">Customer ID</label>
                        <input type="text" class="form-control" id="c_user_id" name="c_user_id" value="<?php if (isset($row['c_user_id'])) {echo $row['c_user_id'];} ?>"
                            readonly>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="c_address">Address</label>
                            <input type="text" class="form-control" id="c_address" name="c_address" value="<?php if (isset($row['c_address'])) { echo $row['c_address'];} ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="c_email">Email</label>
                            <input type="email" class="form-control" id="c_email" name="c_email" value="<?php if (isset($row['c_email'])) {echo $row['c_email'];} ?>">
                        </div>

                        <div class="form-group">
                            <label for="c_phonenumber">Mobile</label>
                            <input type="text" class="form-control" id="c_phonenumber" name="c_phonenumber" value="<?php if (isset($row['c_phonenumber'])) {echo $row['c_phonenumber'];} ?>"
                                onkeypress="isInputNumber(event)">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="booking_date">Date</label>
                            <input type="text" class="form-control" id="booking_date" name="booking_date" value="<?php if (isset($row['booking_date'])) {echo $row['booking_date'];} ?>">
                        </div>

                        <div class="form-group">
                            <label for="booking">Confirm Booking</label>
                            <select class="form-control" id="booking" name="booking">
                                <option value="Confirm Booking">Confirm Booking</option>
                                <option value="Not available">Not available</option>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label for="booking">Confirm Booking</label>
                            <input type="text" class="form-control" id="booking" name="booking">
                        </div> -->
                    </div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-success" name="assign">Confirm</button>
                        <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                    </div>
                </form>
                <!-- Display message if required -->
                <?php if (isset($msg)) {
                    echo $msg;
                } ?>
            </div>
        </div>
    </div> <!-- End Row -->
</div> <!-- End Container -->


<!-- Only Number for input fields -->
<script>
    function isInputNumber(evt) {
        var ch = String.fromCharCode(evt.which);
        if (!(/[0-9]/.test(ch))) {
            evt.preventDefault();
        }
    }
</script>


