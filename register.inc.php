<?php
include_once 'db_connect.php';
include_once 'config.php';
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize og valider dataen der bliver sat ind
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Hvis email er invalid
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // Hashed password skal være 128 tegn
        // Hvis ikke er der sket noget mærkeligt
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
 
    // Username validering og password validering er blevet checkert clientside
    // Dette bør være tilstrækkelig validering eftersom ingen får noget ud af at snyde her

    $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
   // check eksisterende emails 
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // En bruger med samme email findes allerede
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
                        $stmt->close();
        }
                $stmt->close();
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
                $stmt->close();
    }
 
    // check eksisterende usernames
    $prep_stmt = "SELECT id FROM members WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
 
                if ($stmt->num_rows == 1) {
                        // En bruger med samme username findes allerede
                        $error_msg .= '<p class="error">A user with this username already exists</p>';
                        $stmt->close();
                }
                $stmt->close();
        } else {
                $error_msg .= '<p class="error">Database error line 55</p>';
                $stmt->close();
        }
 
    // TODO: 
    // Vi skal også chekce rettighederne for den bruger som prøver at udføre handlingen
 
    if (empty($error_msg)) {
        //Random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Virker ikke
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
<<<<<<< HEAD
        // Indsæt ny bruger i databsen
        if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, salt) VALUES (?, ?, ?, ?)")) {
=======
        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO brugere (brugernavn, email, kode, salt) VALUES (?, ?, ?, ?)")) {
>>>>>>> a233f327927a9c7a52e4c633f85c488cb421e7b2
            $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
            // Execute query
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
        header('Location: ./register_success.php');
    }
}