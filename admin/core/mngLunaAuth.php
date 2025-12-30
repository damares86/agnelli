<?php
##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

spl_autoload_register('autoloader');

function autoloader($class)
{
    include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";

// get the form data
$postpass = filter_input(INPUT_POST, 'password');

$email = filter_input(INPUT_POST, 'email');;
$luna->email = $email;

$luna->table = 'luna_users';
$stmt = $luna->showAllWhere('id', ['email']);

// match the email and the password
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    
    if (password_verify($postpass, $row['password'])) {
        if ($_POST['remember']) {
            $token = md5($email);
            $addToken = substr(md5(uniqid(rand(), 1)), 3, 10);
            $token = $token . $addToken;

            $luna->table = 'luna_users' ;
            $luna->email = $email;
            $luna->auth_token = $token;

            $luna->update(['auth_token'], 'email');
            setcookie("damares-luna-login", $row['id'] . "," . $token, time() + (60 * 60 * 24 * 365 * 10), "/");
        }

        session_start();

        // set session data
        $_SESSION['luna_loggedin'] = true ;
        $_SESSION['luna_user_id'] = $row['id'];
        $_SESSION['luna_name'] = $row['name'];
        $_SESSION['luna_username'] = $row['username'];
        $_SESSION['luna_email'] = $row['email'];
      
        header("Location: ../../portal");
        exit;
    }
} else {

    // header("Location: ../../login/auth-login.php?err=errUserPsw");
    header("Location: ../../portal/login.php?err=errUserPsw");
    exit;
}
