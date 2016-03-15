<?
	require_once 'constants.php';

	session_start();
	require_once("connect.php");

	if(!isset($_SESSION["uid"])) header("Location: login.php");
	if(!isset($_POST["items"])) header("Location: http://incentive.ketupat.me");
	$push = str_replace("'", "", $_POST["items"]);
	$total = 0;
	$charity = 0;
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
		<h4>Purchases</h4>
		<div class="row">
			<table class="bordered hoverable col s8 offset-s2">
		        <thead>
		          <tr>
		              <th data-field="name">Item name</th>
		              <th data-field="price">Item Price</th>
		          </tr>
		        </thead>

		        <tbody>
		        <?php
		        $items = json_decode($_POST["items"], true);
				foreach($items as $row){
					$name = substr($row["name"], 0, strlen($row["name"])/3);
					$total += $row["taxedPrice"];
					$charity += $row["taxedPrice"] - $row["rawPrice"];
					?>
					<tr>
						<td><?php echo $name; ?></td>
						<td>$<?php echo $row["taxedPrice"]; ?></td>
					</tr>
					<?php
				}
		        ?>
		        <tr style="background-color: #ebebeb;">
		        	<td>Total Price</td>
		        	<td>$<?php echo $total; ?></td>
		        </tr>
		        <tr style="background-color: #ebebeb;">
		        	<td>Amount going to charity</td>
		        	<td>$<?php echo $charity; ?></td>
		        </tr>
		        </tbody>
		     </table>
		</div>

		<div class="row">
			<h5>Please enter your security code</h5>
		  	<form class="col s12" action="/php/transaction.php" method="post">
		    	<div class="row">
		      		<div class="input-field col s4 offset-s4">
		      			<i class="mdi-action-credit-card prefix"></i>
		        		<input id="cvc" type="number" name="cvc" autocomplete="off" required>
		        		<label for="cvc">CVC</label>
		      		</div>
		      	</div>
		      	<input type="hidden" name="items" value='<?php echo $push; ?>'>
				<button class="btn waves-effect waves-light btn-large" type="submit" name="submit">Purchase items
			    	<i class="mdi-content-send right"></i>
				</button>
			</form>
		</div>
		<?=JQUERY?>
		<?=MATERIALIZE_JS?>
		<script>
			window.history.pushState('', 'Payment', '/payment');
		</script>
	</body>
</html>