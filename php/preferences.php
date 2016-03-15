<?
	require 'constants.php';
	require_once('connect.php');
	session_start();
	if(!isset($_SESSION['uid'])) header('Location: login.php');
	else if($_SESSION['uid']==-1) header('Location: login.php');
	else{ $suc = true; }
	
	$query = "SELECT * FROM `users` WHERE `uid`=".$_SESSION['uid'].";";
	$result = mysqli_query($mysqli, $query) or die(mysqli_error());
		
		if(mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_assoc($result)){
				$email = $row['email'];
				$cname = $row['nameOnCard'];
				$expmonth = $row['expMonth'];
				$expyear = $row['expYear'];
				$cardno = $row['cardNumber'];
				$tax = $row['tax'];
				$foodtax = $row['foodtax'];
				$mediatax = $row['mediatax'];
				$clothtax = $row['clothestax'];
				$misctax = $row['misctax'];
				$dest = $row['destination'];
				$fname = $row['firstName'];
				$lname = $row['lastName'];
				$add1 = $row['address1'];
				$add2 = $row['address2'];
				$zip = $row['zipCode'];
				$city = $row['city'];
				$state = $row['state'];
				$cty = $row['country'];
				$phone = $row['phoneNumber'];
			}
		} else{
			
			$suc = false;
			//header('Location: login.php');
		}
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Preferences</title>
		<?=MATERIALIZE_CSS?>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<?=RESPONSIVE_META.FAVICON?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<h2 class="header thin">
					<div class="col s1 offset-s3">
						<img class="responsive-image prefix" src="../pig.png" width="100%" />
					</div>
					<div class="col s4">Preferences</div>
					<div class="col s1">
						<img class="responsive-image prefix" src="../pig.png" width="100%" />
					</div>
				</h2>
			</div>
			<div class="row">
				<form class="col s12" action="process_pref.php" method="post">
					<div class="card white">
						<div class="card-content">
							<span class="card-title black-text">Basic Info</span>
							<div class="row">
								<div class="input-field col m6 s12">
									<input type="email" id="email" name="email" value="<? echo $email; ?>"  required> 
									<label for="email">Email</label>
								</div>

								<div class="input-field col m6 s12">
									<input type="password" id="password" name="password" required>
									<label for="password">Password</label>
								</div>
							</div>
						</div>
					</div>

					<div class="card white">
						<div class="card-content">
							<span class="card-title black-text">Card Details</span>
							<div class="row">
								<div class="input-field col s12">
									<input type="text" name="name" value="<? echo $cname; ?>"  required> 
									<label for="name">Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m6 s12">
									<input type="text" name="cardNo" id="cardNo" value="<? echo $cardno; ?>"  required> 
									<label for="cardNo">Card Number</label>
								</div>
								<div class="col m3 s6">
									<select name="expMonth" required>
										<option value="" disabled selected>Expiry Month</option>
										<? 	
											$i = 1;
											$months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
											foreach($months as $month){
												if($i == $expmonth) echo "<option value='$i' selected>$month</option>";
												else echo "<option value='$i'>$month</option>";
												$i++;}
										?>
									</select>
								</div>
								<div class="col m3 s6">
									<select name="expYear" required>
										<option value="" disabled selected>Expiry Year</option>
										<? for($year=2015;$year<2050;$year++){
											if($year-2000 == $expyear) echo "<option selected>$year</option>";
											else echo "<option>$year</option>"; }?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="card white">
						<div class="card-content">
							<span class="card-title black-text">Mailing Address</span>
							<div class="row">
								<div class="input-field col m6 s12">
									<input type="text" name="fname" value = "<? echo $fname;?>" required>
									<label for="fname">First Name</label>
								</div>

								<div class="input-field col m6 s12">
									<input type="text" name="lname" value = "<? echo $fname;?>" required>
									<label for="lname">Last Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="text" name="add1" value = "<? echo $add1;?>" required>
									<label for="add1">Address (Line 1)</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									<input type="text" name="add2" value = "<? echo $add2;?>">
									<label for="add2">Address (Line 2)</label>
								</div>
								<div class="input-field col s12 m6">
									<input type="text" name="zip" id="zip" value = "<? echo $zip;?>" required>
									<label for="zip" id="zip">Zip/Postal Code</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m4 s12">
									<input type="text" name="city" value = "<? echo $city;?>" required>
									<label for="city">City</label>
								</div>
								<div class="input-field col m4 s12">
									<input type="text" name="state" value = "<? echo $state;?>" required>
									<label for="state">State</label>
								</div>
								<div class="input-field col m4 s12">
									<input type="text" name="country" value = "<? echo $cty;?>" required>
									<label for="country">Country</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m12 s12">
									<input type="text" name="contact" value = "<? echo $phone;?>" required>
									<label for="contact">Contact Number</label>
							</div>
						</div>
					</div>

					<div class="card white">
						<div class="card-content">
							<span class="card-title black-text">Tax Details</span>
							<div class="row">
								<label for="taxrate">
									<h6 class="left-align">Global Tax Rate (<span id="percentage"><?echo $tax*100;?></span>%)</h6>
								</label>
								<div class="col s12">
									<input type="range" name="taxrate" min="1" max="500" id="taxrate" value = "<? echo $tax*100;?>" required>
								</div>
							</div>
							<div class="row">
								<label for="foodtax">
									<h6 class="left-align">Food Tax Rate (<span id="foodpercentage"><?echo $foodtax*100;?></span>%)</h6>
								</label>
								<div class="col s12">
									<input type="range" name="foodtax" min="1" max="500" id="foodtax" value = "<? echo $foodtax*100;?>" required>
								</div>
							</div>
							<div class="row">
								<label for="mediatax">
									<h6 class="left-align">Media Tax Rate (<span id="mediapercentage"><?echo $mediatax*100;?></span>%)</h6>
								</label>
								<div class="col s12">
									<input type="range" name="mediatax" min="1" max="500" id="mediatax" value = "<? echo $mediatax*100;?>" required>
								</div>
							</div>
							<div class="row">
								<label for="clothtax">
									<h6 class="left-align">Clothes Tax Rate (<span id="clothpercentage"><?echo $clothtax*100;?></span>%)</h6>
								</label>
								<div class="col s12">
									<input type="range" name="clothtax" min="1" max="500" id="clothtax" value = "<? echo $clothtax*100;?>" required>
								</div>
							</div>
							<div class="row">
								<label for="misctax">
									<h6 class="left-align">Miscellaneous Tax Rate (<span id="miscpercentage"><?echo $misctax*100;?></span>%)</h6>
								</label>
								<div class="col s12">
									<input type="range" name="misctax" min="1" max="500" id="misctax" value = "<? echo $misctax*100;?>" required>
								</div>
							</div>
							<div class="row">
								<label for="dest">
									<h6 class="left-align">Choose where your money goes</h6>
								</label>
								<div class="row">
									<div class="col m4 s12">
										<input type="radio" name="dest" value="1" id="pickCharity" <?if(($dest)>=1) echo "checked" ?> required>
										<label for="pickCharity">Charity</label>
									</div>

									<div class="col m4 s12">
										<input type="radio" name="dest" value ="0" id="pickSavings"  <?if(($dest)==0) echo "checked" ?> required>
										<label for="pickSavings">Savings</label>
									</div>

									<div class="col m4 s12">
										<input type="radio" name="dest" value ="-1" id="pickDev"  <?if(($dest)==-1) echo "checked" ?> required>
										<label for="pickDev">Support the Developers :D</label>
									</div>
								</div>
							</div>
							<div class="row" id="charityrow">
								<label for="charopt">
									<h6 class="left-align">Select which charity to support</h6>
								</label>
								<div class="row">
									<div class="col m6 s12">
										<input type="radio" name="charopt" value ="0" id="pickEMC" <?if(($dest)==1) echo "checked" ?> >
										<label for="pickEMC">Every Mother Counts</label>
									</div>

									<div class="col m6 s12">
										<input type="radio" name="charopt" value ="1" id="pickGFW" <?if(($dest)==2) echo "checked" ?> >
										<label for="pickGFW">Global Fund for Women</label>
									</div>
								</div>
								<div class="row">
									<div class="col m6 s12">
										<input type="radio" name="charopt" value ="2" id="pickSCWO" <?if(($dest)==3) echo "checked" ?> >
										<label for="pickSCWO">Singapore Council of Women's Organisations</label>
									</div>

									<div class="col m6 s12">
										<input type="radio" name="charopt" value ="3" id="pickAWARE" <?if(($dest)==4) echo "checked" ?> >
										<label for="pickAWARE">AWARE</label>
									</div>
								</div>
							</div>
						</div>
  					</div>
  					<button class="waves-effect waves-light btn-large" type="submit" name="submit">Update</button>
					<a href="profile.php"class="btn waves-effect waves-light btn-large white-text">Profile
						<i class="mdi-action-assessment right"></i>
				</a>
				</form>
			</div>
		</div>
		<?=JQUERY?>
		<?=MATERIALIZE_JS?>
		<script>
			$(document).ready(function() {
			    $('select').material_select();
				if($("#pickCharity").is(":checked")) showCharities();
				else hideCharities();
				$("#pickCharity").change(function(){
					if($("#pickCharity").is(":checked")) showCharities();
					else hideCharities();
				});
				$("#pickSavings").change(function(){
					if($("#pickCharity").is(":checked")) showCharities();
					else hideCharities();
				});
				$("#pickDev").change(function(){
					if($("#pickCharity").is(":checked")) showCharities();
					else hideCharities();
				});
			  });
			
			function showCharities(){
				$("#charityrow").slideDown();
				$("#pickEMC").prop("checked", true);
			}
			function hideCharities(){
				$("#charityrow").slideUp();
				$("#pickEMC").prop("checked", false);
				$("#pickGFC").prop("checked", false);
				$("#pickSCWO").prop("checked", false);
				$("#pickAWARE").prop("checked", false);
			}
			$("#taxrate").on("input change",function(){
				$("#percentage").text($(this).val());
			});
			$("#foodtax").on("input change",function(){
				$("#foodpercentage").text($(this).val());
			});
			$("#mediatax").on("input change",function(){
				$("#mediapercentage").text($(this).val());
			});
			$("#clothtax").on("input change",function(){
				$("#clothpercentage").text($(this).val());
			});
			$("#misctax").on("input change",function(){
				$("#miscpercentage").text($(this).val());
			});
				
			
		</script>
	</body>
</html>