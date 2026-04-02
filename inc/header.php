<?php
require "admin/core/prefix.php";
require "admin/inc/damares_version.php";
session_start();
spl_autoload_register('autoloader');

function autoloader($class)
{
    include("admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files = glob("admin/class/*.php", GLOB_BRACE);
rsort($files);

// creation of the file with all the initialization of the classes
if (!is_file('admin/inc/class_initialize.php')) {
    $file_handle = fopen('admin/inc/class_initialize.php', 'w');
    fwrite($file_handle, '<?php');
    fwrite($file_handle, "\n");
    foreach ($files as $filename) {
        $nomefile = pathinfo($filename);
        $file = $nomefile['filename'];
        $file_var = strtolower($file);
        fwrite($file_handle, '$' . $file_var . ' = new ' . $file . '($db);');
        fwrite($file_handle, "\n");
    }
    if ($prefix) {
        fwrite($file_handle, '$common->prx = "' . $prefix . '_";');
        fwrite($file_handle, "\n");
    }
    fwrite($file_handle, "?>");
    chmod('admin/inc/class_initialize.php', 0777);
}
include "admin/inc/class_initialize.php";

// check if the user is logged
if (!isset($_SESSION['loggedin']) && !isset($_SESSION['account_id'])) {
    require "admin/inc/check_cookie.php";
    header('Location: login/auth-login.php?err=noLogin');
    exit;
} else if (isset($_COOKIE['damares-login'])) {
    $pieces = explode(",", $_COOKIE['damares-login']);
    $auth->id = $pieces[0];
    $id = $pieces[0];
    $auth->auth_token = $pieces[1];

    if (!$auth->checkCookie() > 0) {
        header("Location: login/auth-login.php?err=noLogin");
        exit;
    }

    $role->id = $_SESSION['role_id'];

    $setting->name = "role_redirect";
    $stmt = $setting->showAllWhere('id', ['name']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $redir = $row['value'];

    if ($redir == 1) {
        $stmt = $role->showAllWhere('id', ['id']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        if ($row['redirect'] != "none") {
            header("Location: " . $row['redirect'] . "");
            exit;
        }
    }

    $export = false;
    $plugin->pluginname = "export_xlsx";

    if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
        $export = true;
    }
}

// check if the debug mode is active
$setting->name = "debug";
$dbg = $setting->showAllWhere('id', ['name']);
$row_debug = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row_debug);

if ($row_debug['value'] == 1) {
    require 'admin/vendor/autoload.php';        // If installed via composer
    $debug = new \bdk\Debug(array(
        'collect' => true,
        'output' => true,
    ));
}

// check the language set
$setting->name = "lang";
$stmt = $setting->showByName();
$lang = $stmt['value'];
$_SESSION['lang'] = $lang;

foreach (glob("admin/locale/$lang/*.php") as $row) {
    require "$row";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Affan - PWA Mobile HTML Template">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <meta name="theme-color" content="#0134d4">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <!-- Title -->
  <title>Affan - PWA Mobile HTML Template</title>

  <!-- Favicon -->
  <link rel="icon" href="assets/img/core-img/favicon.ico">
  <link rel="apple-touch-icon" href="assets/img/icons/icon-96x96.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/img/icons/icon-152x152.png">
  <link rel="apple-touch-icon" sizes="167x167" href="assets/img/icons/icon-167x167.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icons/icon-180x180.png">

  <!-- Style CSS -->
  <link rel="stylesheet" href="style.css">

  <!-- Web App Manifest -->
  <link rel="manifest" href="manifest.json">
</head>

<body>
  <!-- Preloader -->
  <div id="preloader">
    <div class="spinner-grow text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>