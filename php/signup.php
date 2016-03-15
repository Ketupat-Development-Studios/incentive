<?
	require 'constants.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Sign Up!</title>
		<?=MATERIALIZE_CSS?>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<?=RESPONSIVE_META.FAVICON?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<h2 class="header thin">Getting Started</h2>
			</div>
			<div class="row">
				<form class="col s12" action="process_register.php" method="post">
					<div class="card white">
						<div class="card-content">
							<span class="card-title black-text">Basic Info</span>
							<div class="row">
								<div class="input-field col m6 s12">
									<input type="email" id="email" name="email" required>
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
									<input type="text" name="name" id="name" required>
									<label for="name">Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m6 s12">
									<input type="text" name="cardNo" id="cardNo" required>
									<label for="cardNo">Card Number</label>
								</div>
								<div class="col m3 s6">
									<select name="expMonth" required>
										<option value="" disabled selected>Expiry Month</option>
										<? 	
											$i = 1;
											$months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
											foreach($months as $month){echo "<option value='$i'>$month</option>"; $i++;}
										?>
									</select>
								</div>
								<div class="col m3 s6">
									<select name="expYear" required>
										<option value="" disabled selected>Expiry Year</option>
										<? for($year=2015;$year<2050;$year++){echo "<option>$year</option>";}?>
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
									<input type="text" name="fname" required>
									<label for="fname">First Name</label>
								</div>

								<div class="input-field col m6 s12">
									<input type="text" name="lname" required>
									<label for="lname">Last Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="text" name="add1" required>
									<label for="add1">Address (Line 1)</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									<input type="text" name="add2" >
									<label for="add2">Address (Line 2)</label>
								</div>
								<div class="input-field col s12 m6">
									<input type="text" name="zip" id="zip" required>
									<label for="zip" id="zip">Zip/Postal Code</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m4 s12">
									<input type="text" name="city" required>
									<label for="city">City</label>
								</div>
								<div class="input-field col m4 s12">
									<input type="text" name="state" required>
									<label for="state">State</label>
								</div>
								<div class="input-field col m4 s12">
									<input type="text" name="country" required>
									<label for="country">Country</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m12 s12">
									<input type="text" name="contact" required>
									<label for="contact">Contact Number</label>
							</div>
						</div>
					</div>

					<div class="card white">
						<div class="card-content">
							<span class="card-title black-text">Tax Details</span>
							<div class="row">
								<label for="taxrate">
									<h6 class="left-align">Tax Rate (<span id="percentage"></span>%)</h6>
								</label>
								<div class="col s12">
									<input type="range" name="taxrate" min="1" max="500" id="taxrate" required>
								</div>
							</div>
							<div class="row">
								<label for="dest">
									<h6 class="left-align">Choose where your money goes</h6>
								</label>
								<div class="row">
									<div class="col m4 s12">
										<input type="radio" name="dest" value="1" id="pickCharity" required>
										<label for="pickCharity">Charity</label>
									</div>

									<div class="col m4 s12">
										<input type="radio" name="dest" value ="0" id="pickSavings" required>
										<label for="pickSavings">Savings</label>
									</div>

									<div class="col m4 s12">
										<input type="radio" name="dest" value ="-1" id="pickDev" required>
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
										<input type="radio" name="charopt" value ="0" id="pickEMC">
										<label for="pickEMC">Every Mother Counts</label>
									</div>

									<div class="col m6 s12">
										<input type="radio" name="charopt" value ="1" id="pickGFW">
										<label for="pickGFW">Global Fund for Women</label>
									</div>
								</div>
								<div class="row">
									<div class="col m6 s12">
										<input type="radio" name="charopt" value ="2" id="pickSCWO">
										<label for="pickSCWO">Singapore Council of Women's Organisations</label>
									</div>

									<div class="col m6 s12">
										<input type="radio" name="charopt" value ="3" id="pickAWARE">
										<label for="pickAWARE">AWARE</label>
									</div>
								</div>
							</div>
						</div>
  					</div>
  					<button class="waves-effect waves-light btn-large" type="submit" name="submit">Submit</button>
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
			$("#taxrate").on("input change",function(){
				$("#percentage").text($(this).val());
			});
			function showCharities(){
				$("#charityrow").slideDown();
				$("#pickEMC").prop("checked", true);
			}
			function hideCharities(){
				$("#charityrow").slideUp();
			}

				
			
		</script>
	</body>
</html>