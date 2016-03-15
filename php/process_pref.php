<?
	
	include ("connect.php");
	session_start();
	if(isset($_POST['submit'])){
		if(isset($_SESSION['uid'])){
			if($_SESSION['uid'] > 0 ){
				$email = mysqli_real_escape_string($mysqli, $_POST['email']);
				$password = md5(mysqli_real_escape_string($mysqli, $_POST['password']));
				
				$name = mysqli_real_escape_string($mysqli, $_POST['name']);
				$expMonth = mysqli_real_escape_string($mysqli, $_POST['expMonth']);
				$expYear = mysqli_real_escape_string($mysqli, $_POST['expYear'])-2000;
				$cardNo = mysqli_real_escape_string($mysqli, $_POST['cardNo']);
				
				$fname = mysqli_real_escape_string($mysqli, $_POST['fname']);
				$lname = mysqli_real_escape_string($mysqli, $_POST['lname']);
				$add1 = mysqli_real_escape_string($mysqli, $_POST['add1']);
				$add2 = mysqli_real_escape_string($mysqli, $_POST['add2']);
				$zip = mysqli_real_escape_string($mysqli, $_POST['zip']);
				$city = mysqli_real_escape_string($mysqli, $_POST['city']);
				$state = mysqli_real_escape_string($mysqli, $_POST['state']);
				$country = mysqli_real_escape_string($mysqli, $_POST['country']);
				$contact = mysqli_real_escape_string($mysqli, $_POST['contact']);
				
				
				$taxrate = mysqli_real_escape_string($mysqli, $_POST['taxrate'])/100;
				$foodtax = mysqli_real_escape_string($mysqli, $_POST['foodtax'])/100;
				$mediatax = mysqli_real_escape_string($mysqli, $_POST['mediatax'])/100;
				$clothtax = mysqli_real_escape_string($mysqli, $_POST['clothtax'])/100;
				$misctax = mysqli_real_escape_string($mysqli, $_POST['misctax'])/100;
				$dest = mysqli_real_escape_string($mysqli, $_POST['dest']);
				if($dest == 1) $dest = $_POST['charopt']+$dest;
				//echo ("$name, $expMonth, $expYear, $cardNo, $taxrate, $dest");
				$query = "UPDATE users SET email='$email', password = '$password', nameOnCard = '$name', expMonth = $expMonth, expYear = $expYear, 
						  cardNumber = $cardNo, tax = $taxrate, foodtax = $foodtax, mediatax = $mediatax, clothestax = $clothtax, misctax = $misctax, 
						  destination = $dest, firstName = '$fname', lastName = '$lname', address1 = '$add1', address2 = '$add2', 
						  zipCode = '$zip', city = '$city', state = '$state', country = '$country', phoneNumber = $contact WHERE uid = ".$_SESSION['uid'].";";
				//$query = "INSERT INTO users (email, password, nameOnCard, expMonth, expYear, cardNumber, tax, foodtax, mediatax, clothestax, misctax, destination, firstName, lastName, address1, address2, zipCode, city, state, country, phoneNumber)
				//			VALUES('$email', '$password', '$name', $expMonth, $expYear, $cardNo, $taxrate, $taxrate, $taxrate, $taxrate, $taxrate, $dest, '$fname', '$lname', '$add1', '$add2', '$zip', '$city', '$state', '$country', $contact);";
				//echo ($query);
				
				$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
				if($result){
					header('Location: preferences.php');
					die();
					//echo "SUCCESS";
				} else {
					echo "ERROR";
				}
				
			} else header('Location: login.php');
		} else header('Location: login.php');
	} else header('Location: preferences.php');
?>
