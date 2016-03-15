<html>

	<head>
		<title>Sign-in to &#60;incentive&#62; </title>
		<link rel="stylesheet" type="text/css" href="../style.css">
	</head>
	<body>
		<img src="../logo.png" />
		<form action="api.php" method="post">
			<h2> Signing into &#60;KEYNES&#62; </h2>
			uid:
			<input type="text" name="user_id" <? if(isset($_SESSION['uid'])) echo "value=".$_SESSION['uid']; ?> placeholder="e.g. wildpotato@tuber.com" required> </input> <br /><br>
			Action:
			<input type="text" name="action" value = "retrieveTransactions" required> </input> <br /><br>
			howManyDays:
			<input type="text" name="howManyDays" required> </input><br><br>
			<br>
			<input type="submit" name="submit" value = "Submit" style="font-size:20px; padding:5px;"/>
		</form>
	</body>
</html>