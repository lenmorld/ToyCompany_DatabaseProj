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
				  FROM Items
				  WHERE companyItemID = '$itemID' ;";

		$resultDInfo = $conn->query($qDInfo);	

		if ($resultDInfo->num_rows > 0) {
			
			$rowDInfo = $resultDInfo->fetch_assoc();

			$itemID = $rowDInfo['companyItemID'];
			$name = $rowDInfo['name'];
			$numColor= $rowDInfo['numOfColor'];

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
			$itemID++;
		}
		
		
		
		/*
		
		
		//query to get max employee# plus 1
		$qNextID = "SELECT MAX(departmentID) AS max FROM Departments;";

		$resultNextID = $conn->query($qNextID);	

		if ($resultNextID->num_rows > 0) {
			$rowCID = $resultNextID->fetch_assoc();
			//###### echo $rowCID['max'];
			$dID = $rowCID['max'];
			$dID++;
		}
		*/
		
	}	
}
else {
// ADD or EDIT button clicked
//if (isset($_POST['updateDepartment'])) 
	$itemID = $_POST['itemID'];
	
	//echo "POST:" . $_POST['dID'];
	
	$task = $_POST['task'];

    $itemID = $_POST['itemID'];
    $name = $_POST['name'];
    $numColor= $_POST['numColor'];

	//ADD OR EDIT
	
	if ( $task == 'EDIT') 		//EDIT
	{
		//echo 'EDITTT!' ;
		
		$qEdit = "UPDATE Items
				  SET name='$name'
				  WHERE companyItemID='$itemID' ;"  ;

		echo $qEdit;
		
		if ($conn->query($qEdit) === TRUE) {
			echo "<br/>Record edited successfully";
			
			//header('Location: ./index.php');
			//exit;
		} else {
			echo "<br/>Error: " . $qEdit. "<br>" . $conn->error;
		}
		
		unset($task);
		
		$conn->close();
	}
	else if ($task == 'ADD')		// ADD
	{
		//$ID = $_POST['ID'];

		$qAdd = "INSERT INTO Items(companyItemID, name, numOfColor)
					VALUES('$itemID' , '$name', '$numColor' );";
					
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
	<title>Add/Edit/Delete Items UMC-353-4</title>
	
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
          <h3><?php echo (isset($task)) ? $task . " an Item" : 'Item Details' ?> </h3>
          <form id="reg-form" method="post" action="updateItem.php">
					<div>
					  <label for="itemID">Item ID</label>
					  <input type="text" id="itemID" name="itemID" placeholder="TMC 000-000-001" value="<?php echo $itemID; ?>"   />
					</div>
					
					<div>
					  <label for="name">Name</label>
					  <input type="text" id="deptName" name="name" placeholder="name" value="<?php if (isset($name)) echo $name; ?>"/>
					</div>			
					<div>
					  <label for="numColor">Num of Color</label>
					  <input type="number" id="numColor" name="numColor" placeholder="100" value="<?php if (isset($numColor)) echo $numColor; ?>"/>
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