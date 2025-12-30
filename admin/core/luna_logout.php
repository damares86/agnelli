<?php

require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

session_start();
session_destroy();

spl_autoload_register('autoloader');

function autoloader($class){
	include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

require "../inc/class_initialize.php" ;

// $module = $plugin->showAll('id');
// foreach($module as $row){
//     $plugin->pluginname = $row['pluginname'] ;
//         if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
//             $scan = scandir("plugins/".$row['pluginname']."/class");
//             $exclude = array('..', '.','.gitkeep');
//             foreach($scan as $file){
//             if (!in_array($file,$exclude)) {
//                 $item = pathinfo($file);
//                 include "class/plugin/".$item['basename']."";
//             }
//         }
//     }
// }

if(isset($_COOKIE['damares-luna-login'])){
    $pieces = explode(",", $_COOKIE['damares-luna-login']);
    echo "pieces<br>";
    print_r($pieces);
    $id = $pieces[0];
    $luna->id = $pieces[0];
    $token = "none";
    $luna->auth_token = "none";
    $luna->table = 'luna_users';


    $luna->update(['auth_token'],'id');

    unset($_COOKIE['damares-luna-login']);
    setcookie("damares-luna-login", '', time() - 3600,"/");
}


// Redirect to the login page:
header('Location: ../../portal/login.php');
?>