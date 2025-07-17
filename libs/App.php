<?php
    class App{
        public $host = HOST;
        public $dbname = DBNAME;
        public $user = USER;
        public $pass = PASS;

        public $link;


        //create a construct or type of function 

        public function __construct(){
            $this->connect();
            // $this->host;
        }

        public function connect(){
            $this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname."",$this->user,$this->pass);

            if($this->link) {
                // echo "db connection is working";
            }
            
        }


        //select all

        public function selectAll($query) {
           $rows =  $this->link->query($query);
           $rows->execute();

           $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

           if($allRows) {
                return $allRows;
           }else {
                return false;
           }
        }


        //Select one row

        public function selectOne($query) {
            $row =  $this->link->query($query);
            $row->execute();
 
            $singleRow = $row->fetch(PDO::FETCH_OBJ);
 
            if($singleRow) {
                 return $singleRow;
            }else {
                 return false;
            }
         }


            //Insert query

         public function insert($query, $arr, $path) {

            if($this->validate($arr) == "empty") {
                echo "<script>alert('One or more inputs are empty')</script>";
            } else{

                $insert_record = $this->link->prepare($query);
                $insert_record->execute($arr);

                header("location: ".$path."");

            }
         }

        //Update query
         public function update($query, $arr, $path) {

            if($this->validate($arr) == "empty") {
                echo "<script>alert('One or more inputs are empty')</script>";
            } else{

                $update_record = $this->link->prepare($query);
                $update_record->execute($arr);

                header("location: ".$path."");

            }
         }


         //Delete query
         public function delete($query, $arr, $path) {

                $delete_record = $this->link->prepare($query);
                $delete_record->execute($arr);

                header("location: ".$path."");

         }


         public function validate($arr) {
            if(in_array("", $arr)) {
                echo "empty";
            }
         }



         //Register Query

         public function register($query, $arr, $path) {

            if($this->validate($arr) == "empty") {
                echo "<script>alert('One or more inputs are empty')</script>";
            } else{

                $register_record = $this->link->prepare($query);
                $register_record->execute($arr);

                header("location: ".$path."");

            }
         }


         public function login($query, $data, $path) {

            //email

            $login_user = $this->link->query($query);
            $login_user->execute();

            $fetch = $login_user->fetch(PDO::FETCH_ASSOC);

            if($login_user->rowCount() > 0) {

                //Password

                if(password_verify($data['password'], $fetch['password'])) {

                    //start session variables
                    $_SESSION['email'] = $fetch['email'];
                    $_SESSION['username'] = $fetch['username'];
                    $_SESSION['user_id'] = $fetch['id'];
                    $_SESSION['phone'] = $fetch['phone'];
                    $_SESSION['address'] = $fetch['address'];

                    header("location: ".$path."");
                    // exit;
                }
            }
         }

         //Starting Session

         public function startingSession() {
            session_start();
         }


         //Validating sessions

         public function validateSession() {
            if(isset($_SESSION['user_id'])) {
                // header("location: ".APPURL."");
                echo "<script>window.location.href='".APPURL."'</script>"; //Jokhn login thakbe tkhn url theke login/sighnup page e jawa jabe na
            }
         }


         //Admin login

         public function adminlogin($query, $data, $path) {

            //email

            $admin_user = $this->link->query($query);
            $admin_user->execute();

            $fetch = $admin_user->fetch(PDO::FETCH_ASSOC);

            if($admin_user->rowCount() > 0) {

                //Password

                if(password_verify($data['password'], $fetch['password'])) {

                    //start session variables
                    // $_SESSION['email'] = $fetch['email'];
                    // $_SESSION['username'] = $fetch['username'];
                    // $_SESSION['user_id'] = $fetch['id'];

                    header("location: ".$path."");
                    // exit;
                }
            }
         }


    }


    // $obj = new App;