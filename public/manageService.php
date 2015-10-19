<?php

if(isset($_SERVER['HTTP_REFERER'])) {
    echo $_SERVER['HTTP_REFERER'];
}

require_once '../core/init.php';
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
    <br><br>
    <div class="row">
        <button id = "home" type="button" class="btn btn-success">Home</button>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-5">
            <h2>Current Services</h2>
            <?php
            $db = DB::getInstance();
            $services = $db->query("SELECT * FROM services");

            foreach ($services as $row) {
                $name = $row["name"];
                $id = $row["id"];
                //echo $name.$id;

            ?>
            <div class="row">
                <div class="form-group col-lg-4">
                    <?php echo $name; ?>
                </div>

                    <form action="update_user.php?id = test" role = "form" method="post">
                        <div class="form-group col-lg-4">
                            <button type="submit"  class = "btn btn-success  btn-block " formaction="serviceRegister.php?id=<?php echo $id ?>">Update</button>
                        </div>
                        <div class="form-group col-lg-4">
                            <button type="submit"  class = "btn btn-success  btn-block " formaction="delete.php?id=<?php echo $id ?>">Delete</button>
                        </div>
                    </form>
            </div>


            <?php
            }
            ?>

        </div>


    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/js.js"></script>
</body>
</html>
