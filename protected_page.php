<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Loginsystem</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
            <p>Velkommen <?php echo htmlentities($_SESSION['brugernavn']); ?>!</p>
            <p>
                Dette er et eksempel på en sikker side, som kun kan ses, når brugeren er logget ind i systemet.
            </p>
            <p>Tilbage til <a href="index.php">loginsiden</a></p>
        <?php else : ?>
            <p>
                <span class="error">Du er ikke autoriseret til at se denne side.</span> Venligst <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>