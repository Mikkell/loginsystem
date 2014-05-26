<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

include("header.php");

if (isset($_GET['error'])) {
    echo '<p class="error">Error Logging In!</p>';
}
?> 
<!DOCTYPE html>
<html>
<head>
    <title>Loginsystem</title>
</head>
<body>
<form action="includes/process_login.php" method="post" name="login_form">                      
    Email: <input type="text" name="email" />
    Password: <input type="kode" 
                     name="kode" 
                     id="kode"/>
    <input type="button" 
           value="Login" 
           onclick="formhash(this.form, this.form.kode);" /> 
</form>
<p>Hvis du ikke har en bruger,  <a href="register.php">register dig</a></p>
<p>Hvis du er færdig, <a href="includes/logout.php">log ud</a>.</p>
<p>Du er nu <?php echo $logged ?>.</p>
</body>
</html>
<?php include("footer.php"); ?>