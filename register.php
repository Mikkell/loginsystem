<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>register.php</title>
<style>
/* let's use a little bit decoration :) */
a{
    text-decoration:none;
    color:black;
    margin-left:5px;
    margin-right:5px;
    }
a:hover{text-decoration:underline;}
</style></head>
<body>
<a href="index.php">Home</a>-<a href="register.php">Register</a>-<a href="login.php">Login</a>-<a href="logout.php">Logout</a><hr />
<!-- Creating various field to get user information -->
<form action="register.php" method="post">
<!-- I'm going to use simplest way of co-ordinating fields with text field, yes the tables! -->
    <table>
        <tr><td>Username</td><td><input type="text" name="username" /></td></tr><!-- be careful here, name in the input field will be used as $_POST[$namevalue] while confirming registration -->
        <tr><td>Password</td><td><input type="text" name="password" /></td></tr>
        <tr><td>Confirm Password</td><td><input type="text" name="confirmpassword" /></td></tr>
        <tr><td>Email address</td><td><input type="email" name="email" /></td></tr>
        <tr><td colspan="2"><!-- Registration error if happens --></td></tr>
        <tr><td colspan="2"><input type="submit" value="Register now!" /></td></tr>
    </table>
</form>
</body>
</html> 

<?php
session_start(); // Starting sesssion
//Unsetting $error, that we'll use later to save error information
unset($error);
// Connecting to the mysql database
$host = "localhost"; // Mysql host name goes here
$hpass = "";// Mysql host password goes here
$huser = "root";// Mysql host username goes here
if(!mysql_connect($host,$huser,$hpass)) die("Unable to connect the database");
if(!mysql_select_db("security_login")) die("Unable to connect the database");
//Defining post variables if defined.
if(isset($_POST['username']) || isset($_POST['password'])) // Means user have clicked the register button
{
     //Now I'm defining various variables
    $username = htmlspecialchars(mysql_real_escape_string($_POST['username'])); /* Mysql_real_escape_string helps to pervent sql injections*/
    $password = htmlspecialchars(mysql_real_escape_string(md5(sha1($_POST['password']))));/* md5 & sha1 is used to encrypt plain text into algorithm based special and secret characters, which can't be understood by normal person*/
    $confirmpassword = htmlspecialchars(mysql_real_escape_string(md5(sha1($_POST['confirmpassword']))));
    $email = htmlspecialchars(mysql_real_escape_string($_POST['email']));
   
    //Validating user input
    if($username == NULL || $username == "" || strlen($username) < 4)$error = "Invalid/Empty username field. Please enter your username with more than four characters.
";
    if($email == NULL || $email == "")
    {
        if(isset($error))
        {
            $error = "Email address wasn't entered
".$error;
        }
        else
        {
            $error = "Email address wasn't entered
";     
        }
    }/* Email was validated on input type, if you are still not goodwith it, you can use pregmatch for email validation.*/
    if($password != $confirmpassword)
    {
        if(isset($error))
        {
            $error = "Your passwords didn't match with each other
".$error;
        }
        else
        {
            $error = "Your passwords didn't match with each other
";
        }     
    }
    //Check if username is already exists
    $sql = "SELECT * FROM users WHERE username = '$username'"; /* means all rows from the table.*/
    $result = mysql_query($sql); // Performed query
    if(mysql_num_rows($result) > 0)// There is a result, means username already exists.
    {
         if(isset($error))
         {
             $error = "Username already exists!
". $error;
         }
         else
         {
             $error = "Username already exists!";
         }
    }
   
 
    //Storing information in database
 
    $sql = "INSERT INTO `users`(`username`, `password`, `email`) VALUES ('$username','$password','$email')";/* SQL command to insert into database*/
    if(!isset($error)){ // To check if there is any validation error
        if(mysql_query($sql)) // Perform query
        {
            echo "Your account is registered successfully!, please <a href='login.php'>Login</a> to proceed";
        }
        else
        {
            die("Unable to create user account ".mysql_error());
        }
    }
}
?>

