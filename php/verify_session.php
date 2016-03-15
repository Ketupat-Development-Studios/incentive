<?
	session_start();
	if(!isset($_SESSION['uid'])) echo -1;
	else echo $_SESSION['uid'];
?>