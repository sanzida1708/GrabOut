<?php

// Check if the "View" button is clicked
if (isset($_POST['view'])) {
    if (isset($_POST['id'])) {
        $c_user_id = $_POST['id'];
        $sql = "SELECT * FROM checkout WHERE id = $c_user_id";
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
    if(($_REQUEST['id'] == "") || ($_REQUEST['name'] == "") || ($_REQUEST['user_id'] == "") || ($_REQUEST['Address'] == "") || ($_REQUEST['email'] == "") || ($_REQUEST['number'] == "") || ($_REQUEST['total_products'] == "") || ($_REQUEST['total_price'] == "") || ($_REQUEST['created_at'] == "") || ($_REQUEST['order'] == "")){
     // msg displayed if required field missing
     $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
    } else {
      // Assigning User Values to Variable
      $rid = $_REQUEST['id'];
      $rname = $_REQUEST['name'];
      $ruserid = $_REQUEST['user_id'];
      $raddress = $_REQUEST['Address'];
      $remail = $_REQUEST['email'];
      $rnumber = $_REQUEST['number'];
      $rproducts = $_REQUEST['total_products'];
      $rprice = $_REQUEST['total_price'];
      $rdate = $_REQUEST['created_at'];
      $rassigntech = $_REQUEST['order'];
      
      $sql = "INSERT INTO order_confirm_tb (order_id, name, user_id, address, email, number, total_products, total_price, time_date, order_confirm)
       VALUES ('$rid', '$rname','$ruserid', '$raddress', '$remail', '$rnumber', '$rproducts','$rprice', '$rdate', '$rassigntech')";
       if($conn->query($sql) == TRUE){
       // below msg display on form submit success
       $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Booking Confirmed Successfully </div>';
       // after assigning work we will delete data from submitrequesttable by pressing close button
            
        $sql = "DELETE FROM checkout WHERE id = {$_REQUEST['id']}";
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

?>


<!-- Right side form -->
<div class="right-section">
            <div class="col-sm-12 mt-5 jumbotron">
                <form action="" method="POST">
                    <h5 class="text-center">Admin Order Delivery Confirmation</h5>
                    <div class="form-group">
                        <label for="id">Order ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="<?php if (isset($row['id'])) {echo $row['id'];} ?>"
                            readonly>
                    </div>
                
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php if (isset($row['name'])) { echo $row['name'];} ?>">
                    </div>

                    <div class="form-group">
                        <label for="user_id">Customer ID</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="<?php if (isset($row['user_id'])) {echo $row['user_id'];} ?>"
                            readonly>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="Address">Address</label>
                            <input type="text" class="form-control" id="Address" name="Address" value="<?php if (isset($row['Address'])) { echo $row['Address'];} ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($row['email'])) {echo $row['email'];} ?>">
                        </div>

                        <div class="form-group">
                            <label for="number">Mobile</label>
                            <input type="text" class="form-control" id="number" name="number" value="<?php if (isset($row['number'])) {echo $row['number'];} ?>"
                                onkeypress="isInputNumber(event)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_products">Total Products</label>
                        <input type="text" class="form-control" id="total_products" name="total_products" value="<?php if (isset($row['total_products'])) {echo $row['total_products'];} ?>">
                    </div>
                    <div class="form-group">
                        <label for="total_price">Total Price</label>
                        <input type="text" class="form-control" id="total_price" name="total_price" value="<?php if (isset($row['total_price'])) { echo $row['total_price'];} ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="created_at">Date</label>
                            <input type="text" class="form-control" id="created_at" name="created_at" value="<?php if (isset($row['created_at'])) {echo $row['created_at'];} ?>">
                        </div>

                        <div class="form-group">
                            <label for="order">Confirm Order</label>
                            <select class="form-control" id="order" name="order">
                                <option value="Order Confirm">Order Confirm</option>
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



