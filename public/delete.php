<?php
require_once '../core/init.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];
    $db = DB::getInstance();
    echo $id;
    $delete = $db->query("DELETE FROM services WHERE id = :id",array("id"=> $id));
    header('location: manageService.php');
}
?>
