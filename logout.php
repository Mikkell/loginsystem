<?php
session_start();
//destroy the user session
session_destroy();
die("Du er blevet logget ud! <a href='index.php'>Til forsiden!</a>");?>