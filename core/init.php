<?
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'user_name' => 'root',
        'password' => 'root',
        'db' => 'testDB'
    )
);


spl_autoload_register(function($classname){
    $filename ='../classes/' . $classname .'.php';
    if(file_exists($filename)){
        require $filename;
    }
    else{
        echo $classname;
        echo "There is no such file";
    }
});