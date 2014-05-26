<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<?php include("header.php"); ?>
<?php
if (isset($_GET['error'])) {
    echo '<p class="error">Error Logging In!</p>';
}
?> 
<form action="includes/process_login.php" method="post" name="login_form">                      
    Email: <input type="text" name="email" />
    Password: <input type="password" 
                     name="password" 
                     id="password"/>
    <input type="button" 
           value="Login" 
           onclick="formhash(this.form, this.form.password);" /> 
</form>
<p>If you don't have a login, please <a href="register.php">register</a></p>
<p>If you are done, please <a href="includes/logout.php">log out</a>.</p>
<p>You are currently logged <?php echo $logged ?>.</p>

<?php include("footer.php"); ?>