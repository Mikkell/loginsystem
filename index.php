<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>index.php</title>
<style>
a {
    text-decoration:none;
    color:black;
    margin-left:5px;
    margin-right:5px;
    }
a:hover{text-decoration:underline;}
</style></head>
<body>
<a href="index.php">Home</a>-<a href="register.php">Register</a>-<a href="login.php">Login</a>-<a href="logout.php">Logout</a><hr />
Welcome back, <?php if(isset($_SESSION['name']))
                    {
                        echo $_SESSION['name'];
                    }
                    else
                    {
                        echo "Guest";
                    }?>
</body>
</html>