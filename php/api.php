<?

	/*
		HOW TO SEND POST REQUESTS

		NECESSARY POST VARIABLE: $_POST['action']
		this can be 'retrieveTransactions'

		retrieveTransaction
		requires user_id and howManyDays
		returns json_encoded array 
		example: [{"amount":18,"taxedAmount":18,"itemname":"The Three-Body Problem","time":"2015-03-27 07:17:33"},{"amount":15,"taxedAmount":30,"itemname":"POTATOES RUSSET FRESH PRODUCE 5 LBS","time":"2015-03-28 21:53:00"}]
	*/

	require_once('connect.php');
	date_default_timezone_set('Asia/Singapore');
	if(empty($_POST['action'])){die("no action specified");}

	$action = $_POST['action'];
	switch($action){
		case 'retrieveTransactions':
			if(empty($_POST['user_id']) || empty($_POST['howManyDays'])){invalidData();}
			$user_id = $mysqli->real_escape_string($_POST['user_id']);
			$howManyDays = $mysqli->real_escape_string($_POST['howManyDays']);

			$maxDate = time();
			$minDate = time() - ((int)$howManyDays)*24*60*60;
			/*
			echo "SELECT trans.amount,
						 trans.taxedAmount,
						 trans.itemID,
						 trans.time.
						 items.itemname
				  FROM trans 
				  INNER JOIN items
				  ON items.itemid=trans.itemID;
				  WHERE `uid`=$user_id AND 
				  `time` BETWEEN FROM_UNIXTIME($minDate) AND FROM_UNIXTIME($maxDate)";
			*/
			if($statement = $mysqli->prepare("SELECT trans.amount,
													 trans.taxedAmount,
													 trans.time,
													 items.itemname
											  FROM trans 
											  INNER JOIN items
											  ON items.itemid=trans.itemID
											  WHERE trans.uid=? AND 
											  trans.time BETWEEN FROM_UNIXTIME(?) AND FROM_UNIXTIME(?)")) {
		    	$statement->bind_param("sii", $user_id, $minDate, $maxDate);
				if(!$statement->execute()){var_dump($mysqli->error);}	

				$amount = NULL;$taxedAmount = NULL;$itemID = NULL;$time = NULL;
				$statement->bind_result($amount,$taxedAmount,$time,$itemName);
				$resultArray = array();
				while($row = $statement->fetch()){
					$rowArray = array();
					$rowArray['amount'] = $amount;
					$rowArray['taxedAmount'] = $taxedAmount;
					$rowArray['itemname'] = $itemName;
					$rowArray['time'] = $time;
					array_push($resultArray,$rowArray);
				}
				echo json_encode($resultArray);

				$statement->close();
		    }
			break;
			
		case 'getSummary':
			if(empty($_POST['user_id']) || empty($_POST['howManyDays'])){invalidData();}
			$user_id = $mysqli->real_escape_string($_POST['user_id']);
			$howManyDays = $mysqli->real_escape_string($_POST['howManyDays']);

			$maxDate = time();
			$minDate = time() - ((int)$howManyDays)*24*60*60;
			
			echo "SELECT trans.amount,
						 trans.taxedAmount,
						 trans.itemID,
						 trans.time.
						 items.itemname
				  FROM trans 
				  INNER JOIN items
				  ON items.itemid=trans.itemID;
				  WHERE `uid`=$user_id AND 
				  `time` BETWEEN FROM_UNIXTIME($minDate) AND FROM_UNIXTIME($maxDate) ORDER BY time DESC";
		
			if($statement = $mysqli->prepare("SELECT trans.amount,
													 trans.taxedAmount,
													 trans.time,
													 items.itemname,
													 trans.destination
											  FROM trans 
											  INNER JOIN items
											  ON items.itemid=trans.itemID
											  WHERE trans.uid=? AND 
											  trans.time BETWEEN FROM_UNIXTIME(?) AND FROM_UNIXTIME(?)
											  ORDER BY `time` DESC")) {
		    	$statement->bind_param("sii", $user_id, $minDate, $maxDate);
				if(!$statement->execute()){var_dump($mysqli->error);}	

				$amount = NULL;$taxedAmount = NULL;$itemID = NULL;$time = NULL;
				$statement->bind_result($amount,$taxedAmount,$time,$itemName,$dest);
				
				$curDate = date("Y-m-d", $maxDate);
				$resultArray = array();
				$rowArray = array();
				$rowArray['date'] = $curDate;
				$rowArray['amount'] = 0;
				$rowArray['taxedAmount'] = 0;
				$rowArray['items'] = array();
				while($row = $statement->fetch()){
					if($curDate == date("Y-m-d", strtotime($time))){
						$rowArray['amount'] += $amount;
						$rowArray['taxedAmount'] += $taxedAmount;
						$itemArray = array();
						$itemArray['itemName']=$itemName;
						$itemArray['itemAmt']=$amount;
						$itemArray['itemTaxAmt']=$taxedAmount;
						$itemArray['itemDest']=$dest;
						array_push($rowArray['items'], $itemArray);
					} else{
						for($curDate; strtotime($curDate) > strtotime(date("Y-m-d", strtotime($time))); $curDate){
							array_push($resultArray, $rowArray);
							$curDate = date("Y-m-d", strtotime($curDate)-24*60*60);
							$rowArray = array();
							$rowArray['date'] = $curDate;
							$rowArray['amount'] = 0;
							$rowArray['taxedAmount'] = 0;
							$rowArray['items'] = array();
							if(strtotime($curDate) == strtotime(date("Y-m-d", strtotime($time)))){
								$rowArray['amount'] += $amount;
								$rowArray['taxedAmount'] += $taxedAmount;
								$rowArray['dest'] = $dest;
								$itemArray = array();
								$itemArray['itemName']=$itemName;
								$itemArray['itemAmt']=$amount;
								$itemArray['itemTaxAmt']=$taxedAmount;
								$itemArray['itemDest']=$dest;
								array_push($rowArray['items'], $itemArray);
							} else {
								 //$curDate = date("Y-m-d", (strtotime($curDate)-24*60*60));
							}
						}
					}
					
				}
				array_push($resultArray,$rowArray);
				for($curDate; strtotime($curDate) > strtotime(date("Y-m-d", $minDate)); $curDate){
					$curDate = date("Y-m-d", (strtotime($curDate)-24*60*60));
					$rowArray = array();
					$rowArray['date'] = $curDate;
					$rowArray['amount'] = 0;
					$rowArray['taxedAmount'] = 0;
					$rowArray['items'] = array();
					$itemArray = array();
					array_push($rowArray['items'], $itemArray);
					array_push($resultArray,$rowArray);
				}
				echo json_encode($resultArray);

				$statement->close();
		    }
			break;

		case 'getTax':
			if(empty($_POST['uid'])){invalidData();}
			$uid = $mysqli->real_escape_string($_POST['uid']);
			if($statement = $mysqli->prepare("SELECT tax,foodtax,electronicstax,mediatax,clothestax,misctax
											  FROM users 
											  WHERE `uid` = ?")){
				$statement->bind_param("s", $uid);
				if(!$statement->execute()){var_dump($mysqli->error);}	

				$taxes = array();
				$statement->bind_result($taxes['general'],$taxes['food'],$taxes['electronics'],$taxes['media'],$taxes['clothes'],$taxes['misc']);
				$statement->fetch();
				echo json_encode($taxes);
			}
			break;
		default:
			echo "invalid action";
			break;
	}

	function invalidData(){
		die("invalid data provided");
	}
?>