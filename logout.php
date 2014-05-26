<?php
include_once 'includes/functions.php';
sec_session_start();
 
// fjern alle session værdier.
$_SESSION = array();
 
// hent session parametre. 
$params = session_get_cookie_params();
 
// Slet cookies
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// Slet session. 
session_destroy();
header('Location: index.php');