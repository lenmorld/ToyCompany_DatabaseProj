<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication

//############# TESTING CODE ########
echo '<br/>####### Testing code ######<br/>';
print_r($_POST);
echo '<br/>############################<br/>';

//FORM not submitted yet, just loaded from home-page
if (!(isset($_POST['updateDependents']))) {
	
	//check if ADD/EDIT/DELETE dependent
	//$task also contains "ADD". "EDIT", or "DELETE
	
	if (isset($_POST['addDependent']))
	{
		//echo "ADD D";
		$task = 'ADD';
		$dPCare = $_POST['eID'];
		
	}
	else if (isset($_POST['editDependent']))
	{
		//echo "EDIT D";
		$task = 'EDIT';
		
		
		//print_r ($_POST);
		
		//get dependentID passed from POST
		$dSIN = $_POST['dSIN'];
		
		$qDInfo = "SELECT * 
				  FROM Dependents
				  WHERE dSIN = '$dSIN' ;";

		echo $qDInfo;
				  
		$resultDInfo = $conn->query($qDInfo);	

		if ($resultDInfo->num_rows > 0) {
			
			$rowDInfo = $resultDInfo->fetch_assoc();
			$dPCare = $rowDInfo['employeeID'];
			$dName = $rowDInfo['dName'];
			$dDOB= $rowDInfo['dDateOfBirth'];

		}
	}
	else if(isset($_POST['delDependent']))
	{
		//echo "DELETE D";
	}
	
}
else {
// ADD or EDIT button clicked
//if (isset($_POST['updateDependents']))

	$task = $_POST['task'];
	$dSIN = $_POST['dSIN'];
	
	//echo "POST:" . $_POST['eID'];
	
	
	$dPCare = $_POST['dPCare'];
	$dName = $_POST['dName'];
	$dDOB = $_POST['dDOB'];

	//ADD OR EDIT
	
	if ( $task == 'EDIT') 		//EDIT
	{
		//echo 'EDITTT!' ;
		
		$qEdit = "UPDATE Dependents 
				  SET dSIN='$dSIN', dName='$dName', dDateOfBirth='$dDOB'
				  WHERE dSIN='$dSIN' ;"  ;

		echo $qEdit;
		
		if ($conn->query($qEdit) === TRUE) {
			echo "Record edited successfully";
			
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

		echo 'DPCARE' . $dPCare;
		
		$qAdd = "INSERT INTO Dependents(employeeID, dSIN, dName, dDateOfBirth)
					VALUES('$dPCare' , '$dSIN', '$dName', '$dDOB' );";
					
		echo $qAdd;
		
		if ($conn->query($qAdd) === TRUE) {
		echo "New record created successfully";
		} else {
			echo "Error: " . $qAdd . "<br>" . $conn->error;
		}
		

		unset($task);
		
		$conn->close();
		
		
	}
}
?>

<html>

<head>
	<title>Add Dependents UMC-353-4</title>
	
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
          <h3><?php echo (isset($task)) ? $task . " an Employee" : 'Employee Details' ?> </h3>
          <form id="reg-form" method="post" action="updateDependents.php">
					<div>
					  <label for="eID">Primary Care ID</label>
					  <input type="text" id="dPCare" name="dPCare" placeholder="ETMC-000000" value="<?php echo $dPCare; ?>"   />
					</div>
					<div>
					  <label for="dSIN">SIN Number</label>
					  <input type="text" id="dSIN" name="dSIN" placeholder="SOCI-100000" value="<?php if (isset($dSIN)) echo $dSIN; ?>"/>
					</div>
					<div>
					  <label for="dName">Name</label>
					  <input type="text" id="dName" name="dName" placeholder="Firstname Lastname" value="<?php if (isset($dName)) echo $dName; ?>"/>
					</div>			
					<div>
					  <label for="dDOB">DOB</label>
					  <input type="date" name="dDOB" id="dDOB" placeholder="1900-12-30" value="<?php if (isset($dDOB)) echo $dDOB; ?>"/>
					</div>	
					
					<div>
						<input type='hidden' value="<?php echo $task; ?>" name="task" />
					
						<input type="submit" name="updateDependents" value="<?php echo (isset($task)) ? $task : 'UPDATE' ?>" />
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

	<!--h2>Operations completed successfully!</h2-->
	<!--h2><a href="index.php" />HOME</h2-->
	<?php
	echo "
	<h2>Operations completed successfully!</h2>
		<form method='post' action='updateEmployee.php'>
					<input type='hidden' value='" . $dPCare  . "' name='eID' / >
					<input type='hidden' value='EDIT' name='task' />  
					<input type='submit' value='GO BACK TO EMPLOYEE PAGE' />
		</form>     
	";
	
	?>
	
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