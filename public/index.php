<?php
require_once '../core/init.php';

phpinfo();

//require("../classes/DB.php");
//DB2::getInstance() ->query("SELECT * FROM Persons");

$db = DB::getInstance();
$person 	 =     $db->query("SELECT * FROM Persons");
$persons_num =     $db->query("SELECT * FROM Persons", null, PDO::FETCH_NUM);
$insert	 	=  $db->query("INSERT INTO Persons(Firstname,Age) 	VALUES(:f,:age)",array("f"=>"Vivek","age"=>"20"));


function d($v,$t)
{
    echo '<pre>';
    echo '<h1>' . $t. '</h1>';
    var_dump($v);
    echo '</pre>';
}
d($person, "All persons");
d($persons_num, "Fetch Single value, The firstname");

d($insert, "Insert statement");


?>