<?php

require_once '../core/init.php';
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = DB::getInstance();

    echo "hello";

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
                        <input type="email" name="name" class="form-control" id="name" placeholder="Email">

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">E-maile address</label>
                        <input type="text" name="email" class="form-control" id="email" placeholder="Password">

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Contact</label>
                        <input type="text" name="website" class="form-control" id="exampleInputPassword1" placeholder="Password">

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">No of Rooms available</label>
                        <input type="text"  name="comment" class="form-control" id="exampleInputPassword1" placeholder="Password">

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Room Type</label>
                        <input type="text" name="gender" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/js.js"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
    <script src="js/validation.js"></script>

    <?php
    echo "<h2>Your Input:</h2>";
    echo $name;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo $website;
    echo "<br>";
    echo $comment;
    echo "<br>";
    echo $gender;
    ?>

</body>
</html>
