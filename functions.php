<?php
include_once 'config.php';

function sec_session_start() {
	$session_name = 'sec_session_id'; //opret session id
	$secure = SECURE;
	// Dette stopper javascripts adgang til session id.
	$httponly = true;
	// Tvinger sessions til kun at bruge cookies.
	if (ini_set('session.use_only_cookies', 1) === FALSE) {
		header("Location: ../error.php?err=Could not initiate a safe session")
		exit();
	}
	// henter parametre for cookies.
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"],
		$cookieParams[path]
		$cookieParams[domain]
		$secure
		$httponly);
	// sætter sessions navnet efter ovennævnte.
	session_name ($session_name);
	session_start();	//starter php sessionen.
	session_regenerate_id();	//regenerer sessionen og sletter den gamle.
}