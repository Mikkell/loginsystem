<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Loginsystem - registreringsform</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <!-- Registrerings formen skal være output hvis POST variablerne ikke er sat
        eller hvis registration script giver en fejl. -->
        <h1>Registrer bruger</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Brugernavne må kun indeholde tal, små og store bogstaver og understregninger.</li>
            <li>Emails skal have det korrekte email format.</li>
            <li>Koden skal indeholde mindst 6 cifre.</li>
            <li>Koden skal indeholde:
                <ul>
                    <li>Mindst ét stort bogstav (A..Z)</li>
                    <li>Mindst ét lille bogstav (a..z)</li>
                    <li>Mindst ét tal (0..9)</li>
                </ul>
            </li>
        </ul>
        <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" 
                method="post" 
                name="registration_form">
            Brugernavn: <input type='text' 
                name='username' 
                id='brugernavn' /><br>
            Email: <input type="text" name="email" id="email" /><br>
            Kode: <input type="password"
                             name="password" 
                             id="kode"/><br>
            Gentag kode: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmkode" /><br>
            <input type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>
        <p>Tilbage til <a href="index.php">loginsiden</a>.</p>
    </body>
</html>