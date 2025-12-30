<?php

if(isset($_COOKIE['damares_luna_login'])){
    $pieces = explode(",", $_COOKIE['damares-luna-login']);
    $luna->id = $pieces[0];
    $id = $pieces[0];
    $luna->auth_token = $pieces[1];

    $luna->table = 'luna_users' ;

    if($luna->checkCookie()>0){
                     
        session_start();

        // set session data
        $_SESSION['luna_loggedin'] = true ;
        $_SESSION['luna_user_id'] = $row['id'];
        $_SESSION['luna_name'] = $row['name'];
        $_SESSION['luna_username'] = $row['username'];
        $_SESSION['luna_email'] = $row['email'];
      
    } else {
        header("Location: login.php?err=noLogin");
        exit;
    }
}