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

function login($email, $password, $mysqli) {
	// brug af prepared statements for at undgå SQL-injections.
	if ($stmt = $mysqli->prepare("SELECT id, brugernavn, kode, salt FROM brugere WHERE email = ? LIMIT 1")) {
		$stmt->bind_param('s', $email); //binder "$email" til parameteret.
		$stmt->execute();	//udfører den forberedte query.
		$stmt->store_result();

		// hent variabler fra resultat.
		$stmt->bind_result($user_id, $username, $db_password, $salt);
		$stmt->fetch();

		//hash koden med den unikke salt.
		$password = hash('sha512', $password . $salt);
		if (stmt->num_rows == 1) {
			//hvis brugeren eksisterer, tjekker vi efter om kontoen er låst pga. for mange forsøg

			if (checkbrute($bruger_id, $mysqli) == true) {
				//kontoen er låst. - send email til bruger.
				return false;
			} else {
				//tjek om koden i databasen passer med brugerens input.
				if ($db_password == $kode) {
					//koden er korrekt!
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					//XSS beskyttelse.
					$user_id = preg_replace("/[^0-9]+/", "", $user_id);
					$_SESSION['bruger_id'] = $bruger_id;
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
					$_SESSION['username'] = $username;
					$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
					//login succes.
					return true;
				} else {
					//koden er ikke korrekt - optaget i databasen.
					$now = time();
					$mysqli->query("INSERT INTO login_forsøg(bruger_id, tid) VALUES ('$bruger_id', '$now')");
					return false;
				}
			}
		} else {
			//brugeren findes ikke.
			return false;
		}
	}
}

function checkbrute($bruger_id, $mysqli) {
	//tidsstempel
	$now = time();

	//login-forsøg fra seneste tre timer bliver talt med.
	$valid_attempts = $now - (3*60*60);

	if ($stmt = $mysqli->prepare("SELECT time FROM login_forsøg WHERE bruger_id = ? AND time > '$valid attempts'")) {
		$stmt->bind_param('i', $bruger_id);

		//kør query
		$stmt->execute();
		$stmt->store_result();

		//hvis der har været mere end 3 forkerte login forsøg.
		if ($stmt->num_rows > 3) {
			return true;
		} else {
			return false;
		}
	}
}

function login_check($mysqli) {
	//tjek om session variabler er klar.
	if (isset($_SESSION['bruger_id'], $_SESSION['brugernavn'], $_SESSION['login_string'])) {
		$bruger_id = $_SESSION['bruger_id'];
		$login_string = $_SESSION['login_string'];
		$brugernavn = $_SESSION['brugernavn'];

		//Hent bruger_id fra brugeren.
		$user_browser = $_SERVER['HTTP_USER_AGENT'];

		if ($stmt = $mysqli->prepare("SELECT kode FROM brugere WHERE id = ? LIMIT 1")) {
			//bind bruger_id til parameter.
			$stmt->bind_param('i', $bruger_id);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows == 1) {
				//hvis brugeren eksisterer, hent resultater fra variabler.
				$stmt->bind_result($kode);
				$stmt->fetch();
				$login_check = hash('sha512', $kode . $user_browser);

				if ($login_check == $login_string) {
					//logget på.
					return true;
				} else {
					//ikke logget på.
					return false;
				}
			} else {
				//ikke logget på.
				return false;
			}
		} else {
			//ikke logget på.
			return false;
		}
	} else {
		//ikke logget på.
		return false;
	}
}