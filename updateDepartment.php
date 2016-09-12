<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication

//############# TESTING CODE ########
//echo '<br/>####### Testing code ######<br/>';
//print_r($_POST);
//echo '<br/>############################<br/>';

//FORM not submitted yet, just loaded from previous page
if (!(isset($_POST['updateDepartment']))) {				
	

	if (isset($_POST['task']) && $_POST['task'] == 'EDIT' )			//EDIT
	{
		$task = 'EDIT';

		//print_r ($_POST);
		
		//get departmentID passed from POST
		$dID = $_POST['dID'];
		
		$qDInfo = "SELECT * 
				  FROM Department
				  WHERE departmentID = '$dID' ;";

		$resultDInfo = $conn->query($qDInfo);	

		if ($resultDInfo->num_rows > 0) {
			
			$rowDInfo = $resultDInfo->fetch_assoc();

			$dName = $rowDInfo['deptName'];
			$dRoomNum = $rowDInfo['roomNumber'];
			$dFax = $rowDInfo['faxNumber'];
			$dTel1 = $rowDInfo['phoneNumber1'];
			$dTel2 = $rowDInfo['phoneNumber2'];
		}
	}
	else
	{
		$task = 'ADD';
		
		$dID = $_POST['dID'];
		
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
	$dID = $_POST['dID'];
	
	echo "POST:" . $_POST['dID'];
	
	$task = $_POST['task'];

	$dName = $_POST['deptName'];
	$dRoomNum = $_POST['roomNumber'];
	$dFax = $_POST['faxNumber'];
	$dTel1 = $_POST['phoneNumber1'];
	$dTel2 = $_POST['phoneNumber2'];

	//ADD OR EDIT
	
	if ( $task == 'EDIT') 		//EDIT
	{
		//echo 'EDITTT!' ;
		
		$qEdit = "UPDATE Department
				  SET deptName='$dName', roomNumber='$dRoomNum', faxNumber='$dFax', phoneNumber1='$dTel1', phoneNumber2='$dTel2'
				  WHERE departmentID='$dID' ;"  ;

		echo $qEdit;
		
		if ($conn->query($qEdit) === TRUE) {
			echo "<br/>Record edited successfully";
			
			//header('Location: ./index.php');
			//exit;
		} else {
			echo "<br/>Error: " . $qEdit . "<br>" . $conn->error;
		}
		
		unset($task);
		
		$conn->close();
	}
	else if ($task == 'ADD')		// ADD
	{
		//$ID = $_POST['ID'];

		$qAdd = "INSERT INTO Department(departmentID, deptName, roomNumber, faxNumber, phoneNumber1, phoneNumber2)
					VALUES('$dID' , '$dName', '$dRoomNum', '$dFax', '$dTel1', '$dTel2' );";
					
		//echo $qAdd;
		
		if ($conn->query($qAdd) === TRUE) {
		echo "<br/> New department added successfully";
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
	<title>Add/Edit/Delete Department UMC-353-4</title>
	
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
          <h3><?php echo (isset($task)) ? $task . " a Department" : 'Department Details' ?> </h3>
          <form id="reg-form" method="post" action="updateDepartment.php">
					<div>
					  <label for="dID">Department ID</label>
					  <input type="text" id="dID" name="dID" placeholder="BOARD-102" value="<?php echo $dID; ?>"   />
					</div>
					
					<div>
					  <label for="dName">Department Name</label>
					  <input type="text" id="deptName" name="deptName" placeholder="Firstname" value="<?php if (isset($dName)) echo $dName; ?>"/>
					</div>			
					<div>
					  <label for="roomNumber">Room Number</label>
					  <input type="number" id="roomNumber" name="roomNumber" placeholder="100" value="<?php if (isset($dRoomNum)) echo $dRoomNum; ?>"/>
					</div>
					<div>
					  <label for="faxNumber">Fax</label>
					  <input type="text" id="faxNumber" name="faxNumber" placeholder="514-123-4567" value="<?php if (isset($dFax)) echo $dFax; ?>"/>
					</div>
					<div>
					  <label for="phoneNumber1">Telephone 1</label>
					  <input type="text" id="phoneNumber1" name="phoneNumber1" placeholder="514-123-4567" value="<?php if (isset($dTel1)) echo $dTel1; ?>"/>
					</div>
					<div>
					  <label for="phoneNumber2">Telephone 2</label>
					  <input type="text" id="phoneNumber2" name="phoneNumber2" placeholder="514-123-4567" value="<?php if (isset($dTel2)) echo $dTel2; ?>"/>
					</div>
					<div>
						<input type='hidden' value="<?php echo $task; ?>" name="task" />
					
						<input type="submit" name="updateDepartment" value="<?php echo (isset($task)) ? $task : 'UPDATE' ?>" />
					</div>
			
					<br/>
					
					
	<?php /*				
	$dName = $_POST['deptName'];
	$dRoomNum = $_POST['roomNumber'];
	$dFax = $_POST['faxNumber'];
	$dTel1 = $_POST['phoneNumber1'];
	$dTel2 = $_POST['phoneNumber2']; */
	?>
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