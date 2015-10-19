<?php

require_once '../core/init.php';

//define variable

$name = $email = $contact = $noOfRooms = $type = $insert = "";
$update = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = DB::getInstance();
    if (isset($_POST['name'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $noOfRooms = $_POST['noOfRooms'];
        $type = $_POST['type'];


        $querySelect = $_POST['select'];
        if ($querySelect){
            $id = $_POST['currentId'];
            $result = $db->query("UPDATE services SET name = :name, contact = :contact, email = :email, noOfRooms = :noOfRooms, type = :type WHERE  id = :id", array("name"=>$name,"contact"=>$contact,"email"=>$email,"noOfRooms"=>$noOfRooms,"type"=>$type, "id"=>$id));
            echo $result;

        }else{
            $insert = $db->query("INSERT INTO services(`name`, `contact`, `email`, `noOfRooms`, `type`) VALUES(:name,:contact,:email,:noOfRooms,:type)",array("name"=>$name,"contact"=>$contact,"email"=>$email,"noOfRooms"=>$noOfRooms,"type"=>$type));
            echo $insert;
        }
    }

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = $db->query("SELECT * FROM services WHERE id = :id",array("id"=> $id));
        $result = $result[0];
        $name = $result['name'];
        $email = $result['email'];
        $contact = $result['contact'];
        $noOfRooms = $result['noOfRooms'];
        $type = $result['type'];
        $update = true;

        echo $id;
    }



}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <br><br>
            <button id = "home" type="button" class="btn btn-success">Home</button>

        </div>


        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <br><br>
                <form  id="serviceRegisterForm" method="post" action="serviceRegister.php">
                    <div class="form-group">
                        <label for="SeviceName">Hotel name</label>
                        <input type="email" name="name" class="form-control" id="name" value="<?php echo$name;  ?>" >

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">E-maile address</label>
                        <input type="text" name="email" class="form-control" id="email" value="<?php echo$email; ?>" >

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Contact</label>
                        <input type="text" name="contact" class="form-control" id="exampleInputPassword1" value="<?php echo$contact; ?>" >

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">No of Rooms available</label>
                        <input type="text"  name="noOfRooms" class="form-control" id="exampleInputPassword1" value="<?php echo$noOfRooms; ?>" >

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Room Type</label>
                        <input type="text" name="type" class="form-control" id="exampleInputPassword1" value="<?php echo$type; ?>" >
                    </div>

                    <input type="hidden" value="<?php if($update){echo true;}else{echo false;}?>" name="select" />
                    <input type="hidden" value="<?php echo$id; ?>" name="currentId" />

                    <button type="submit" class="btn btn-default"><?php if($update){echo 'Update';}else{echo 'Register';} ?></button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/js.js"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
    <script src="js/validation.js"></script>



</body>
</html>
