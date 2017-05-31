<?php
	session_start();
	if(substr($_SERVER['REMOTE_ADDR'],0,10) == '192.168.1.'){
		$_SESSION['auth']=1;
	}
	if(!isset($_SESSION['auth']) && isset($_COOKIE['user']) && isset($_COOKIE['pass'])){
		$passhash=crypt("password", "WautehSAOhsnthO8989snthSTStnh");
		if($_COOKIE['user'] == 'username' && hash_equals($_COOKIE['pass'], $passhash)){
			$_SESSION['auth']=1;
		}

	}
	if(!isset($_SESSION['auth']) && !isset($_POST['uname'])){
		print '<form method="post">Username:<input type="text" name="uname"><br>Password:<input type="password" name="pass">';
		print '<input type="checkbox" value="1" name="remember">Remember this device?<br>';
		print '<br><input type="submit" value="Log In">';
		die();
	} elseif(!isset($_SESSION['auth']) && isset($_POST['uname'])){
		#Lazy authentication system, hardcoded credentials. I view this as OK for personal use.
		if($_POST['uname']=='username' && $_POST['pass']=='password'){
			$_SESSION['auth']=1;
			if(isset($_POST['remember'])){
				$cookiePass=crypt($_POST['pass'], "WautehSAOhsnthO8989snthSTStnh");
				setcookie("pass",$cookiePass,time()+60*60*24*7);
				setcookie("user","username",time()+60*60*24*7);
			}
		} else {
			die("Invalid login");
		}
	}
?>
