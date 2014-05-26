<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start(); // Vi kører PHP i secure-mode.
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // Den hashede kode.
 
    if (login($email, $password, $mysqli) == true) {
        // Login succes. 
        header('Location: ../protected_page.php');
    } else {
        // Login fejl. 
        header('Location: ../index.php?error=1');
    }
} else {
    // Forkert POST variabel sendt. 
    echo 'Invalid Request';
}