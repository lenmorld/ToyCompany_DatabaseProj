<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication

//############# TESTING CODE ########
//echo '<br/>####### Testing code ######<br/>';
//print_r($_POST);
//echo '<br/>############################<br/>';

//FORM not submitted yet, just loaded from previous page
if (!(isset($_POST['updateItem']))) {				
	

	if (isset($_POST['task']) && $_POST['task'] == 'EDIT' )			//EDIT
	{
		$task = 'EDIT';

		//print_r ($_POST);
		
		//get departmentID passed from POST
		$itemID = $_POST['itemID'];
		
		$qDInfo = "SELECT * 
				  FROM Inventory
				  WHERE companyItemID = '$itemID' ;";

		$resultDInfo = $conn->query($qDInfo);	

		if ($resultDInfo->num_rows > 0) {
			
			$rowDInfo = $resultDInfo->fetch_assoc();

			$itemID = $rowDInfo['companyItemID'];
			$date = $rowDInfo['dateOfManufacture'];
            $price = $rowDInfo['unitPrice'];
            $qty = $rowDInfo['iQuantity'];

		}
	}
	else
	{
		$task = 'ADD';
		
		$itemID = $_POST['itemID'];
        
        
        //query to get max employee# plus 1
		$qNextID = "SELECT MAX(companyItemID) AS max FROM Items;";

		$resultNextID = $conn->query($qNextID);	

		if ($resultNextID->num_rows > 0) {
			$rowNID = $resultNextID->fetch_assoc();
			//####### echo $rowNID['max'];
			$itemID = $rowNID['max'];
			//$itemID++;
		}
		
		
	}	
}
else {
// ADD or EDIT button clicked
//if (isset($_POST['updateDepartment'])) 
	$itemID = $_POST['itemID'];
	
	//echo "POST:" . $_POST['dID'];
	
	$task = $_POST['task'];

    $itemID = $_POST['itemID'];
    $date = $_POST['dateOfManufacture'];
    $price = $_POST['unitPrice'];
    $qty = $_POST['iQuantity'];

	//ADD OR EDIT
	
	if ( $task == 'EDIT') 		//EDIT
	{

		$qEdit = "UPDATE Inventory
				  SET unitPrice='$price', iQuantity='$qty'
				  WHERE companyItemID='$itemID' ;"  ;

		echo $qEdit;
		
		if ($conn->query($qEdit) === TRUE) {
			echo "<br/>Record edited successfully";
			
		} else {
			echo "<br/>Error: " . $qEdit . "<br>" . $conn->error;
		}
		
		unset($task);
		
		$conn->close();
	}
	else if ($task == 'ADD')		// ADD
	{
		//$ID = $_POST['ID'];

		$qAdd = "INSERT INTO Inventory(companyItemID, dateOfManufacture, unitPrice, iQuantity)
					VALUES('$itemID' , '$date', '$price', '$qty' );";
					
		//echo $qAdd;
		
		if ($conn->query($qAdd) === TRUE) {
		echo "<br/> New item added successfully";
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
	<title>Add/Edit/Delete Inventory Items UMC-353-4</title>
	
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
          <h3><?php echo (isset($task)) ? $task . " an Inventory Item" : 'Inventory Item Details' ?> </h3>
          <form id="reg-form" method="post" action="updateInv.php">
					<div>
					  <label for="itemID">Item ID</label>
					  <input type="text" id="itemID" name="itemID" placeholder="TMC 000-000-001" value="<?php echo $itemID; ?>"   />
					</div>
		
					<div>
					  <label for="date">Date</label>
					  <input type="date" id="date" name="dateOfManufacture" placeholder="100" value="<?php if (isset($date)) echo $date; ?>"/>
					</div>
					<div>
					  <label for="name">Price</label>
					  <input type="text" id="deptName" name="unitPrice" placeholder="name" value="<?php if (isset($price)) echo $price; ?>"/>
					</div>
                    
					<div>
					  <label for="name">Quantity</label>
					  <input type="text" id="deptName" name="iQuantity" placeholder="name" value="<?php if (isset($qty)) echo $qty; ?>"/>
					</div>	
					<div>
						<input type='hidden' value="<?php echo $task; ?>" name="task" />
                        
						<input type="submit" name="updateItem" value="<?php echo (isset($task)) ? $task : 'UPDATE' ?>" />
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
	<h2>Operations completed successfully!</h2>
	<h2><a href="index.php" />HOME</h2>
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