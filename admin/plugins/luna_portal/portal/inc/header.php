<?php
session_start();


// check if the user is logged in
require __DIR__ . "/config.php";

$luna->table = 'luna_settings';
$luna->name = 'users';
$check_stmt = $luna->showAllWhere('id', ['name']);
$check_row = $check_stmt->fetch(PDO::FETCH_ASSOC);
extract($check_row);
$check_user = false ;

if ($check_row['value'] == 1) {
  
  $check_user = true;
  if (!isset($_SESSION['luna_loggedin'])) {

    require 'inc/check_cookie.php';
    header('Location: login.php?err=noLogin');
    exit;
  } else if (isset($_COOKIE['luna_loggedin'])) {
    $pieces = explode(",", $_COOKIE['luna_loggedin']);
    $luna->id = $pieces[0];
    $id = $pieces[0];
    $luna->auth_token = $pieces[1];

    if (!$luna->checkCookie() > 0) {
      header("Location: login.php?err=noLogin");
      exit;
    }
  }
}

$page = "Home";
if (filter_input(INPUT_GET, 'prod')) {
  $luna->table = 'luna_products';
  $luna->id = filter_input(INPUT_GET, 'prod');

  if(!$luna->itemExists('id')){
    header('Location: index.php?err=prodNoExist');
    exit;
  }
  
  $stmt2 = $luna->showAllWhere('id', ['id']);
  $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
  extract($row2);
  $page = $row2['name'];
}
function getPageNumberFromUrl($url) {
  // Definisce la regex per estrarre il valore del parametro 'page'
  $regex = '/[?&]page=(\d+)/';
  if (preg_match($regex, $url, $matches)) {
    return $matches[1];
  }
  return null;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $page ?> - Luna Portal</title>

  <!--
    ##############    Damares    ###############
    #                                          #
    #    A backend project by DM WebLab        #
    #   Website: https://www.dmweblab.com      #
    #   GitHub: https://github.com/damares86   #
    #                                          #
    ############################################
    -->
  <link rel="stylesheet" href="../admin/assets/css/main/app.css" />
  <link rel="stylesheet" href="../admin/assets/css/main/app-dark.css" />
  <link rel="shortcut icon" href="assets/img/logo/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="assets/img/logo/favicon.ico" type="image/png" />
  <link rel="stylesheet" href="../admin/assets/extensions/choices.js/public/assets/styles/choices.css" />

  <link rel="stylesheet" href="../admin/assets/css/shared/iconly.css" />
  <?php

  foreach (glob("assets/css/*.css") as $row) {
  ?>
    <link rel="stylesheet" href="<?= $row ?>" />
  <?php
  }
  ?>
  <script src="../admin/assets/extensions/jquery/jquery.min.js"></script>

</head>