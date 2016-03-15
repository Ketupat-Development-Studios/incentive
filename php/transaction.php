<?php
	session_start();
	require_once("connect.php");
	require_once("simplify/lib/Simplify.php");


	if(isset($_SESSION["uid"])) $uid = $_SESSION["uid"];
	else header("Location: login.php");
	if(isset($_POST["items"])) $items = json_decode($_POST["items"], true);
	if(isset($_POST["cvc"])) $cvc = $_POST["cvc"];

	echo $_POST["items"]."\n";

 	$query = mysqli_query($mysqli, "SELECT * FROM `users` WHERE uid='$uid'") or die(mysql_error());
	if(mysqli_num_rows($query)>0){
		while($row=mysqli_fetch_assoc($query)){
			$destination = $row["destination"];
			$nameOnCard = $row["nameOnCard"];
			$expMonth = $row["expMonth"];
			$expYear = $row["expYear"];
			$cardNumber = $row["cardNumber"];
			$tax = $row["tax"];
			$destination = $row["destination"];
			$firstName = $row["firstName"];
			$lastName = $row["lastName"];
			$address1 = $row["address1"];
			$address2 = $row["address2"];
			$zipCode = $row["zipCode"];
			$city = $row["city"];
			$state = $row["state"];
			$country = $row["country"];
			$phoneNumber = $row["phoneNumber"];
		}
	}

	$total = 0;

	foreach($items as $row){
		echo $row["deleteID"]."\n";
		$total += $row["taxedPrice"];
		$rawPrice = $row["rawPrice"];
		$taxedAmount = $row["taxedPrice"] - $row["rawPrice"];
		$itemID = $row["itemId"];
		if(isset($uid))
			mysqli_query($mysqli, "INSERT INTO `trans` (uid, amount, taxedAmount, itemID, destination)
				VALUES ('$uid', '$rawPrice', '$taxedAmount', '$itemID', '$destination')")
				or die(mysql_error());
	}


	Simplify::$publicKey = 'sbpb_ODQ4ZTlkZDUtOTkyYS00YjExLTlkOTUtNjgyZDhkN2YzNmI5';
	Simplify::$privateKey = 'QEtlkkkaKvbEvRQBpugqJIKLwBDnFGZ9Rypnm+CgbS55YFFQL0ODSXAOkNtXTToq';
	 
	$payment = Simplify_Payment::createPayment(array(
	        'amount' => $total,
	        'card' => array(
	           'expMonth' => $expMonth,
	           'expYear' => $expYear,
	           'cvc' => $cvc,
	           'number' => $cardNumber
	        )
	));
	 
	if ($payment->paymentStatus == 'APPROVED') {
		$url = "http://www.amazon.com/gp/cart/view.html?";
		foreach($items as $row){
			$url .= "submit.delete.".$row["deleteID"]."=Delete&";
		}
	    header("Location: $url");
	}
	else header("Location: http://www.amazon.com/gp/cart/view.html?");

	/*
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://api.zinc.io/v0/order',
	    "client_token"=> "public",
  		"retailer"=> "amazon",
  		"products"=> [{"product_id"=> $itemID, "quantity": 1}],
		"shipping_address"=> {
		    "first_name"=> $firstName,
		    "last_name"=> $lastName,
		    "address_line1"=> $address1,
		    "address_line2"=> $address2,
		    "zip_code"=> $zipCode,
		    "city"=> $city, 
		    "state"=> $state,
		    "country"=> $country,
		    "phone_number"=> $phoneNumber
		  },
  		"is_gift"=> false,
  		"shipping_method"=> "cheapest",
  		"payment_method"=> {
    		"name_on_card"=> $nameOnCard,
    		"number"=> $cardNumber,
    		"security_code"=> $cvc,
    		"expiration_month"=> $expMonth,
    		"expiration_year"=> $expYear,
    		"use_gift"=> false
  		},
  		"billing_address"=> {
    		"first_name"=> $firstName, 
    		"last_name"=> $lastName,
    		"address_line1"=> $address1,
   			"address_line2"=> $address2,
    		"zip_code"=> $zipCode,
    		"city"=> $city, 
    		"state"=> $state,
    		"country"=> $country,
    		"phone_number"=> $phoneNumber
  		}
	));

	curl_exec($curl);

	curl_close($curl);
	*/
?>