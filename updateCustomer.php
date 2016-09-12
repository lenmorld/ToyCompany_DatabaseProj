<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication

//############# TESTING CODE ########
//echo '<br/>####### Testing code ######<br/>';
//print_r($_POST);
//echo '<br/>############################<br/>';

//FORM not submitted yet, just loaded from previous page
if (!(isset($_POST['updateCustomer']))) {				
	

	if (isset($_POST['task']) && $_POST['task'] == 'EDIT' )			//EDIT
	{
		$task = 'EDIT';

		//print_r ($_POST);
		
		//get customerID passed from POST
		$cID = $_POST['cID'];
		
		$qCInfo = "SELECT * 
				  FROM Customers
				  WHERE customerID = '$cID' ;";

		$resultCInfo = $conn->query($qCInfo);	

		if ($resultCInfo->num_rows > 0) {
			
			$rowCInfo = $resultCInfo->fetch_assoc();

			$cName = $rowCInfo['cName'];
			$cAddress = $rowCInfo['cAddress'];
			$cTel = $rowCInfo['cTelephone'];
		}
	}
	else
	{
		$task = 'ADD';
		
		//query to get max employee# plus 1
		$qNextID = "SELECT MAX(customerID) AS max FROM Customers;";

		$resultNextID = $conn->query($qNextID);	

		if ($resultNextID->num_rows > 0) {
			$rowCID = $resultNextID->fetch_assoc();
			//###### echo $rowCID['max'];
			$cID = $rowCID['max'];
			$cID++;
		}
	}	
}
else {
// ADD or EDIT button clicked
//if (isset($_POST['updateCustomer'])) 
	$cID = $_POST['cID'];
	
	echo "POST:" . $_POST['cID'];
	
	$task = $_POST['task'];

	$cName = $_POST['cName'];
	$cAddress = $_POST['cAddress'];
	$cTel = $_POST['cTel'];

	//ADD OR EDIT
	
	if ( $task == 'EDIT') 		//EDIT
	{
		//echo 'EDITTT!' ;
		
		$qEdit = "UPDATE Customers
				  SET cName='$cName', cAddress='$cAddress', cTelephone='$cTel'
				  WHERE customerID='$cID' ;"  ;

		echo $qEdit;
		
		if ($conn->query($qEdit) === TRUE) {
			echo "<br/>Record edited successfully";
			
			//header('Location: ./index.php');
			//exit;
		} else {
			echo "Error: " . $qEdit . "<br>" . $conn->error;
		}
		
		unset($task);
		
		$conn->close();
	}
	else if ($task == 'ADD')		// ADD
	{
		//$ID = $_POST['ID'];

		$qAdd = "INSERT INTO Customers(customerID, cName, cAddress, cTelephone)
					VALUES('$cID' , '$cName', '$cAddress', '$cTel' );";
					
		//echo $qAdd;
		
		if ($conn->query($qAdd) === TRUE) {
		echo "<br/> New customer added successfully";
		} else {
			echo "<br/> Error: " . $qAdd . "<br>" . $conn->error;
		}
		
		unset($task);
		
		$conn->close();
		
		
	}

}
?>

<html>

<head>
	<title>Add/Edit/Delete Customer UMC-353-4</title>
	
	<link rel="stylesheet" href="css/add.css" type="text/css">

</head>

<body>

<!--------- add employee form ------>

<?php 

if (isset($task))
{ ?>
	

 <div class="main">
      <div class="one">
        <div class="register">
          <h3><?php echo (isset($task)) ? $task . " a Customer" : 'Customer Details' ?> </h3>
          <form id="reg-form" method="post" action="updateCustomer.php">
					<div>
					  <label for="cID">Customer ID</label>
					  <input type="text" id="cID" name="cID" placeholder="CU-000-000-000" value="<?php echo $cID; ?>"   />
					</div>
					
					<div>
					  <label for="cName">Name</label>
					  <input type="text" id="cName" name="cName" placeholder="Firstname Lastname" value="<?php if (isset($cName)) echo $cName; ?>"/>
					</div>			
					<div>
					  <label for="cAddress">Address</label>
					  <input type="text" id="cAddress" name="cAddress" placeholder="1234 Fake Street" value="<?php if (isset($cAddress)) echo $cAddress; ?>"/>
					</div>
					<div>
					  <label for="cTel">Telephone</label>
					  <input type="text" id="cTel" name="cTel" placeholder="514-123-4567" value="<?php if (isset($cTel)) echo $cTel; ?>"/>
					</div>
					<div>
						<input type='hidden' value="<?php echo $task; ?>" name="task" />
					
						<input type="submit" name="updateCustomer" value="<?php echo (isset($task)) ? $task : 'UPDATE' ?>" />
					</div>
			
					<br/>
		  </form>	
	
        </div>
      </div>
	 
		
    </div>
	
<?php 
}
else
{ ?>
	<h3>Operations completed successfully!</h3>
	<h3><a href="index.php" />HOME</h3>
	<h3><a href="addOrder.php" />ADD ORDER</h3>
<?php
}
?>


<!--------------------------------->

<?php 
//close DB connection, only do it after all php-mysql stuff are done
//put it at the end
//$conn->close();
?>
</body>


</html>