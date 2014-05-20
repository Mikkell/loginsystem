<?php include("header.php"); ?>

<form id="login" action="" method="post" accept-charset="utf-8">
    <fieldset>
        <legend>Loginform</legend>
        <input type="hidden" name="submitted" id="submitted" value="1"/>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" maxlength="50"/>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" maxlength="50">
    </fieldset>
</form>

<?php include("footer.php"); ?>