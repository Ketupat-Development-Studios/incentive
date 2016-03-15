<?
	include ("connect.php");
	if(isset($_POST['submit'])){
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
		$dest = mysqli_real_escape_string($mysqli, $_POST['dest']);
		if($dest == 1) $dest = $_POST['charopt']+$dest;
		//echo ("$name, $expMonth, $expYear, $cardNo, $taxrate, $dest");
		$query = "INSERT INTO users (email, password, nameOnCard, expMonth, expYear, cardNumber, tax, foodtax, mediatax, clothestax, misctax, destination, firstName, lastName, address1, address2, zipCode, city, state, country, phoneNumber)
					VALUES('$email', '$password', '$name', $expMonth, $expYear, $cardNo, $taxrate, $taxrate, $taxrate, $taxrate, $taxrate, $dest, '$fname', '$lname', '$add1', '$add2', '$zip', '$city', '$state', '$country', $contact);";
		//echo ($query);
		
		$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
		if($result){
			header('Location: login.php');
			die();
			//echo "SUCCESS";
		} else {
			echo "ERROR";
		}
		
	}
?>
