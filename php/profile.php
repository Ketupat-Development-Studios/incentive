<?
	require_once 'constants.php';
	session_start();
	if(isset($_SESSION['uid'])){
		$uid = $_SESSION['uid'];
		if($uid < 0) header('Location:login.php');
	} else header('Location:login.php');
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
		<div class="container">
			
			<div class="row">
				<h2 class="header thin">
					<div class="col s1 offset-s3">
						<img class="responsive-image prefix" src="../pig.png" width="100%" />
					</div>
					<div class="col s4">Profile</div>
					<div class="col s1">
						<img class="responsive-image prefix" src="../pig.png" width="100%" />
					</div>
				</h2>
			</div>
			
			<div class="row">
				<div class="col s12">
					<div class="card white" style="padding:15px;">
						<div class="row">
						<h2 class="col s10">Welcome to Incentive!</h2>
						<p class="col s2" id="preferencesBtn" style="cursor:pointer;">Preferences</p>
						</div>
						<p>Here is your customized profile page where you get to see all your past transactions made with us and a breakdown of your donations!</p>
						<div class="row">
							<div class="col s6">
								<div class="row">
									<p class="col s8">Amount Donated: </p>
									<p class="col s4" id="disp-taxAmt" style="text-align:right;">$00.00</p>
								</div>
								<div class="row">
									<p class="col s8">Amount Paid: </p>
									<p class="col s4" id="disp-paidAmt" style="text-align:right;">$00.00</p>
								</div>
								<div class="row">
									<p class="col s8">Total Expenditure: </p>
									<p class="col s4" id="disp-totAmt" style="text-align:right;">$00.00</p>
								</div>
							</div>
							<div class="col s6">
								<div id="disp-donation-container" class="row">
									<canvas id="chart-charity" width="150" height="150" style="cursor:pointer;"></canvas>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="row">
											<div class="col-xs-2" id="chart-curCol" style="padding-left:10ps;width:30px;height:30px; position:absolute;right:350px; bottom:100px;">
											
											</div>
											<div class="col-xs-8" id="chart-curLoc" style="font-size:60%;">
											
											</div>
											<div class="col-xs-2" id="chart-curVal">
											
											</div>
										</div>
									</div>
									<div class="col-xs-6"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col s12">
					<div class="card white" style="padding:15px;">
						<div class="row">
							<div id="disp-tax-container">
								<canvas id="chart-tax" width="290" height="150"></canvas>
							</div>
						</div>
						<div class="row" style="display:hidden">
						
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
		<?=JQUERY?>
		<?=MATERIALIZE_JS?>
		<script src="../chrome/js/jquery.cookie.js"></script>
		<script src="../chrome/js/jquery.slimscroll.min.js"></script>
		<script src="../chrome/js/Chart.min.js"></script>
		<script src="../chrome/js/tinycolor.js"></script>
		<script src="../chrome/dist/js/vendor/video.js"></script>
		<script src="../chrome/dist/js/flat-ui.min.js"></script>
		<script src="../chrome/docs/assets/js/application.js"></script>
		<script>
			window.history.pushState('', 'Incentive', '/');
			$.cookie('uid',<?php echo $_SESSION['uid']?>,{expires: 365});
		</script>
		<script src="../js/profile.js"></script>
	</body>
</html>