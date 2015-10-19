<?php
if(isset($_SERVER['HTTP_REFERER'])) {
    echo $_SERVER['HTTP_REFERER'];
}

echo '<br>'.$_GET['id'];
//echo $_GET['update'];
?>