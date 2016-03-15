<?
	require_once 'constants.php';
	session_start();
	if(isset($_SESSION['uid'])){
		$uid = $_SESSION['uid'];
		if($uid > 0) header('Location: profile.php');
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Incentive</title>
		<?=MATERIALIZE_CSS?>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<?=RESPONSIVE_META?>
		<?=FAVICON?>
	</head>
	<body>
		<img class="responsive-image" src="../logo.png" />
		<div class="row">
		  	<form class="col s12" action="php/process_login_web.php" method="post">
		    	<div class="row">
		      		<div class="input-field col m4 s8 offset-m2 offset-s2">
		      			<i class="mdi-communication-email prefix"></i>
		        		<input id="email" type="email" name="email" autocomplete="off" required>
		        		<label for="email">Email</label>
		      		</div>
		      		<div class="input-field col m4 s8">
		      			<i class="mdi-action-lock prefix"></i>
		        		<input id="password" type="password" name="password" autocomplete="off" required>
		        		<label for="password">Password</label>
		      		</div>
		      	</div>
				<button class="btn waves-effect waves-light btn-large" type="submit" name="submit">Login
			    	<i class="mdi-content-send right"></i>
				</button>
				<a href="signup.php"class="btn waves-effect waves-light btn-large red lighten-2">Signup
						<i class="mdi-action-assignment right"></i>
				</a>
			</form>
		</div>
		<?=JQUERY?>
		<?=MATERIALIZE_JS?>
		<script>
			window.history.pushState('', 'Login', '/login');
		</script>
	</body>
</html>