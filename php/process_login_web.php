<?
	session_start();
	include ("connect.php");
	if(isset($_POST['submit'])){
		$email = mysqli_real_escape_string($mysqli, $_POST['email']);
		$password = md5(mysqli_real_escape_string($mysqli, $_POST['password']));
		$query = "SELECT `uid` FROM `users` WHERE `email` = '$email' AND `password` = '$password';";
		
		$result = mysqli_query($mysqli, $query) or die(mysqli_error());
		
		if(mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_assoc($result)){
				$uid = $row["uid"];
			}
			$_SESSION['uid'] = $uid;
			//echo $_SESSION['uid'];
			header('Location: profile.php');
			
		} else{
			$_SESSION['uid'] = -1;
			header('Location: login.php');
		}
		
		echo $_SESSION['uid'];
		die();
		
	}
?>
