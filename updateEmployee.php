<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication

//############# TESTING CODE ########
echo '<br/>####### Testing code ######<br/>';
print_r($_POST);
echo '<br/>############################<br/>';

//FORM not submitted yet, just loaded from home-page
if (!(isset($_POST['updateEmployees']))) {				
	

	if (isset($_POST['task']) && $_POST['task'] == 'EDIT' )			//EDIT
	{
		$task = 'EDIT';
		
		
		//print_r ($_POST);
		
		//get employeeID passed from POST
		$eID = $_POST['eID'];
		
		$qEInfo = "SELECT * 
				  FROM Employees
				  WHERE employeeID = '$eID' ;";

		$resultEInfo = $conn->query($qEInfo);	

		if ($resultEInfo->num_rows > 0) {
			
			$rowEInfo = $resultEInfo->fetch_assoc();
			
			$eSIN = $rowEInfo['eSIN'];
			$eName = $rowEInfo['eName'];
			$eDOB = $rowEInfo['eDateOfBirth'];
			$ePosition = $rowEInfo['position'];
			$eAddress = $rowEInfo['address'];
			$eTel = $rowEInfo['telephone'];
		}
		//###CHECKS
	
		/**
		 *	check from database if Manager, part-time/full-time, salary
		 */
		 //check which department

		$qCheckDept = "SELECT departmentID
						FROM WorksFor
						WHERE employeeID = '$eID' ; ";

		//echo $qCheckDept;
						
		$resultCD = $conn->query($qCheckDept);	

		if ($resultCD->num_rows > 0) {
		
			//if tuple exist given eID is manager
		
			$rowCD = $resultCD->fetch_assoc();
			$dept = $rowCD['departmentID'];
			
			$oldDept = $rowCD['departmentID'];			//### SAVE OLD DEPT
		}
		else {
			echo "<br/>Employee not in any department<br/>";
			//this shuoldnt happen
		} 
		 
		//echo $dept;
		 
		
		//query to see if manager
		$qCheckManager = "SELECT *
						FROM Manages
						WHERE managerID = '$eID' ; ";

		$resultCM = $conn->query($qCheckManager );	

		if ($resultCM->num_rows > 0) {
		
			//if tuple exist given eID is manager
		
			//$rowCM = $resultCM->fetch_assoc();
			
			$manager = true;
		}
		else {
			$manager = false;
		}
		//full time
		$qCheckFT = "SELECT *
						FROM FullTimerEmployees
						WHERE employeeID = '$eID' ; ";

		$resultFT = $conn->query($qCheckFT );	

		if ($resultFT->num_rows > 0) {
			//if tuple exist given eID is FT
			$rowFT = $resultFT->fetch_assoc();
			$type = 'full';	
			//get salary
			$salary = $rowFT['salary'];
		}

		//part time
		$qCheckPT= "SELECT *
						FROM PartTimerEmployees
						WHERE employeeID = '$eID' ; ";

		$resultPT = $conn->query($qCheckPT );	

		if ($resultPT->num_rows > 0) {
		
			//if tuple exist given eID is PT
			$rowPT = $resultPT->fetch_assoc();
			$type = 'part';
			//get salary
			$salary = $rowPT['salary'];
		}
		
		echo "salary: " . $salary;
		//##### finish checks #######
		
	}
	else
	{
		$task = 'ADD';
		
		//query to get max employee# plus 1
		$qNextID = "SELECT MAX(employeeID) AS max FROM Employees;";

		$resultNextID = $conn->query($qNextID);	

		if ($resultNextID->num_rows > 0) {
			$rowNID = $resultNextID->fetch_assoc();
			//####### echo $rowNID['max'];
			$eID = $rowNID['max'];
			
			$employeeIDOrig = $eID;
			
			$eID++;
		}
	}	
}
else {
// ADD or EDIT button clicked
//if (isset($_POST['updateEmployees'])) 
	$eID = $_POST['eID'];
	
	
	$employeeIDOrig = $_POST['employeeIDOrig'];
	
	//echo "POST:" . $_POST['eID'];
	
	$task = $_POST['task'];

	$eSIN = $_POST['eSIN'];
	$eName = $_POST['eName'];
	$eDOB = $_POST['eDOB'];
	$ePosition = $_POST['ePosition'];
	$eAddress = $_POST['eAddress'];
	$eTel = $_POST['eTel'];
	
	
	//#### get Old Dept if set
	
	if (isset($_POST['oldDept']))
		$oldDept = $_POST['oldDept'];
	

	//ADD OR EDIT
	
	if ( $task == 'EDIT') 		//EDIT
	{	
		//echo 'EDITTT!' ;
		
		$salary = $_POST['salary'];
		$type = $_POST['type'];
		
		
		//check inputs		//SOME BAD INPUTS
		if($_POST['dept'] == 'NONE' || empty($_POST['type']) ||  empty($_POST['salary']) ) {
			
			if ($_POST['dept'] == 'NONE')
				echo "<br/>Please pick department";
			
			if (empty($_POST['type']))
			    echo "<br/>Please pick full-time or part-time";
				
			if (empty($salary))
				echo "<br/>Please enter salary";
			//exit;
		}
		else {			//inputs all good	
		
			$salary = $_POST['salary'];
			
			$type = $_POST['type'];
			
			$date = date('Y-m-d');
						
			$dept = $_POST['dept'];
			
			$temp = explode(":", $dept);
			//echo "<br/>" . $temp[0];
			
			$dept = $temp[0];
			
			
			
			//##CHECK IF MOVED DEPARTMENT ############
			
			if ($oldDept != $dept) {
			
			
				echo 'OLD' . $oldDept;
				echo 'NEW' . $dept;
 			
				echo '<br>MOVED DEPARTMENT!</br>';
				
				
				//insert new entry
				$qInsert = "INSERT INTO WorksFor (employeeID, departmentID, startDate)
						VALUES ('$eID', '$dept', '$date');"  ;
					  
				echo $qInsert;
				
				if ($conn->query($qInsert) === TRUE)  {
					echo "new entry added successfully";
						
					//TODO: set oldDept date to today
					//OLD
					$qOld = "UPDATE WorksFor
						  SET endDate='$date'
						  WHERE employeeID='$eID' 
						  AND departmentID='$oldDept';"  ;
						  
					echo $qOld;
					
					if ($conn->query($qOld) === TRUE) 
						echo "Old dept edited successfully";
					else 
						echo "Error: " . $qOld . "<br>" . $conn->error;	

				}
				else 
					echo "Error: " . $qInsert . "<br>" . $conn->error;	
				
				

					



				/*
				//NEW
				$qNew = "UPDATE WorksFor
					  SET startDate='$date'
					  WHERE employeeID='$eID' 
					  AND departmentID='$dept';"  ;
					  
				echo $qNew;
				
				if ($conn->query($qNew) === TRUE) 
					echo "New dept edited successfully";
				else 
					echo "Error: " . $qNew . "<br>" . $conn->error;	
					*/
	
			}
			
			
			//update  employees		
			$qEdit = "UPDATE Employees 
				  SET eName='$eName', eDateOfBirth='$eDOB', position='$ePosition', address='$eAddress', telephone='$eTel'
				  WHERE employeeID='$eID' ;"  ;
				  
			echo $qEdit;
			
			if ($conn->query($qEdit) === TRUE) 
				echo "Record edited successfully";
			else 
				echo "Error: " . $qEdit . "<br>" . $conn->error;
				  
			/*
			//update department
			$qAddW = "UPDATE WorksFor
					SET departmentID='$dept', startDate='$date' 
					WHERE employeeID='$eID' ; ";
	
			echo "<br/>WorksFor update: " .  $qAddW . " <br/>";
					
			if ($conn->query($qAddW) === TRUE) {
			echo "Updated WorksFor successfully";
			} else {
				echo "Error: " . $qAddW . "<br>" . $conn->error;
			}			 
			*/
			
			//update manager
			if (empty($_POST['manager']))
				$manager = false;
			else
				$manager = true;

			if ($manager){
					$qAddM = "UPDATE Manages
						SET departmentID='$dept', startDate='$date';  
						WHERE managerID='$eID' ; ";
					
					//echo "<br/>Manages query: "  . $qAddM . " <br/>";
					
					if ($conn->query($qAddM) === TRUE) {
						echo "Updated Manages successfully";
					} else {
						echo "Error: " . $qAddM . "<br>" . $conn->error;
					}		
			}
			
			
			//PT or FT	
			if ($type == 'part')
			{
			
					$qAddP = "UDPATE PartTimerEmployees
							SET salary='$salary'
							WHERE employeeID='$eID' ; ";
					
					//echo "<br/>PartTime query: "  . $qAddP . " <br/>";
					
					if ($conn->query($qAddP) === TRUE) {
					echo "Updated Part Timer successfully";
					} else {
						echo "Error: " . $qAddP . "<br>" . $conn->error;
					}		
			
			}
			else if ($type == 'full') {

					
					$qAddF = "UPDATE FullTimerEmployees
						SET salary='$salary' 
						WHERE employeeID='$eID' ; ";
					
					//echo "<br/>FullTime query: "  . $qAddF . " <br/>";
					
					if ($conn->query($qAddF) === TRUE) {
						echo "Updated Full Timer successfully";
					} else {
						echo "Error: " . $qAddF . "<br>" . $conn->error;
					}		

			}
			unset($task);	
			$conn->close();
		 }
	
	}
	else if ($task == 'ADD')		// ADD
	{
		$salary = $_POST['salary'];
		$type = $_POST['type'];
		
		//check inputs
		if($_POST['dept'] == 'NONE' || empty($_POST['type']) ||  empty($_POST['salary']) ) {
			
			if ($_POST['dept'] == 'NONE')
				echo "<br/>Please pick department";
			
			if (empty($_POST['type']))
			    echo "<br/>Please pick full-time or part-time";
				
			if (empty($salary))
				echo "<br/>Please enter salary";
			//exit;
		}
		else{			//inputs all good
			
			$salary = $_POST['salary'];
			
			$type = $_POST['type'];
			
			$date = date('Y-m-d');
						
			$dept = $_POST['dept'];
			
			$temp = explode(":", $dept);
			//echo "<br/>" . $temp[0];
			
			$dept = $temp[0];
			
			
			//add to employees
					
			$qAdd = "INSERT INTO Employees(employeeID, eSIN, eName, eDateOfBirth, position, address, telephone)
						VALUES('$eID' , '$eSIN', '$eName', '$eDOB', '$ePosition', '$eAddress', '$eTel' );";
						
			//echo $qAdd;
			
			if ($conn->query($qAdd) === TRUE) {
			echo "New record created successfully";
			} else {
				echo "Error: " . $qAdd . "<br>" . $conn->error;
			}
			
			
			//add to department
			
					
			$qAddW = "INSERT INTO WorksFor(employeeID, departmentID, startDate)
					VALUES('$eID','$dept','$date') ";
					
			echo "<br/>Works for query: " .  $qAddW . " <br/>";
					
			if ($conn->query($qAddW) === TRUE) {
			echo "Inserted into WorksFor successfully";
			} else {
				echo "Error: " . $qAddW . "<br>" . $conn->error;
			}
			
			/********************/
			//other stuff
			
			
			if (empty($_POST['manager']))
				$manager = false;
			else
				$manager = true;
				
			echo "<br/>DEPT" . $dept. "<br/>";
			echo "MANAGER" . $manager . "<br/>";
			echo "TYPE" . $type . "<br/>";
			
			
			/******************************/
	
			//echo 'waahhaha';

					
			if ($manager){
					$qAddM = "INSERT INTO Manages(managerID, departmentID, startDate)
					VALUES('$eID','$dept','$date') ";
					
					echo "<br/>Manages query: "  . $qAddM . " <br/>";
					
					if ($conn->query($qAddM) === TRUE) {
						echo "Inserted into Manages successfully";
					} else {
						echo "Error: " . $qAddM . "<br>" . $conn->error;
					}		
			}
			
			if ($type == 'part')
			{
			
					$qAddP = "INSERT INTO PartTimerEmployees(employeeID, salary)
							VALUES('$eID','$salary') ";
					
					echo "<br/>PartTime query: "  . $qAddP . " <br/>";
					
					if ($conn->query($qAddP) === TRUE) {
					echo "Inserted into Part Timer successfully";
					} else {
						echo "Error: " . $qAddP . "<br>" . $conn->error;
					}		
			
			}
			else if ($type == 'full') {
			
					//------------> ADDING ORIG ID
					
					$qAddF = "INSERT INTO FullTimerEmployees(employeeID, salary)
					VALUES('$eID','$salary') ";
					
					echo "<br/>FullTime query: "  . $qAddF . " <br/>";
					
					if ($conn->query($qAddF) === TRUE) {
						echo "Inserted into Full Timer successfully";
					} else {
						echo "Error: " . $qAddF . "<br>" . $conn->error;
					}		
			
			}
				
			unset($task);
			$conn->close();

		}
	}

}
?>

<html>

<head>
	<title>Add Employees UMC-353-4</title>
	
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
          <form id="reg-form" method="post" action="updateEmployee.php">
					<div>
					  <label for="eID">Employee ID</label>
					  <input type="text" id="eID" name="eID" placeholder="ETMC-000000" value="<?php echo $eID; ?>"   />
					</div>
					<div>
					  <label for="eSIN">SIN Number</label>
					  <input type="text" id="eSIN" name="eSIN" placeholder="100 300 0000" value="<?php if (isset($eSIN)) echo $eSIN; ?>"/>
					</div>
					<div>
					  <label for="eName">Name</label>
					  <input type="text" id="eName" name="eName" placeholder="Firstname Lastname" value="<?php if (isset($eName)) echo $eName; ?>"/>
					</div>			
					<div>
					  <label for="eDOB">DOB</label>
					  <input type="date" name="eDOB" id="eDOB" placeholder="1900-12-30" value="<?php if (isset($eDOB)) echo $eDOB; ?>"/>
					</div>	
					<div>
					  <label for="ePosition">Position</label>
					  <input type="text" id="ePosition" name="ePosition" placeholder="Slave" value="<?php if (isset($ePosition)) echo $ePosition; ?>"/>
					</div>
					<div>
					  <label for="eAddress">Address</label>
					  <input type="text" id="eAddress" name="eAddress" placeholder="1234 Fake Street" value="<?php if (isset($eAddress)) echo $eAddress; ?>"/>
					</div>
					<div>
					  <label for="eTel">Telephone</label>
					  <input type="text" id="eTel" name="eTel" placeholder="514-123-4567" value="<?php if (isset($eTel)) echo $eTel; ?>"/>
					</div>
					
					<!------ dept, manager, full-time part-time -------->
					<div> <?php //echo "dept" . $dept; ?>
					<label for="dept">Department</label>
						<select name="dept">
							<option value="NONE">Select Department </option>
									<?php
										//get all departments
								
										
								
										$qCInfo = "SELECT departmentID, CONCAT(departmentID, ':', deptName) AS Dept
												  FROM Department;";
								
										$resultCInfo = $conn->query($qCInfo);	
								
										if ($resultCInfo->num_rows > 0) {
											while($rowC = $resultCInfo ->fetch_assoc()) {
											
												//echo $rowC['departmentID'];
												if ($dept == $rowC['departmentID'])
													$str = ' selected';
												else
													$str= ' ';						
											
												echo '<option value="' . $rowC['Dept'] . '"  '. $str .'   > ' . $rowC['Dept']  .   ' ' . '  </option>' ;
											}
										}
									?>			
						</select>
						<!-- start date would be today -->
					
					</div>
					
					<div>
						<input type="checkbox" name="manager" id="manager" value="Manager" <?php if ($manager) echo 'checked'; ?> />
						<label for="manager">Manager</label>
					</div>
					
					<div>
						<label for="type">Type</label>
						<input type="radio" name="type" id="type" value="full" <?php if ($type=='full') echo 'checked'; ?> />Full-Timer
						<input type="radio" name="type" id="type" value="part" <?php if ($type=='part') echo 'checked'; ?>/>Part-Timer
					</div>
					
					<div>
					  <label for="salary">Salary</label>
					  <input type="text" id="salary" name="salary" placeholder="10000" value="<?php if (isset($salary)) echo $salary; ?>"/>
					</div>
					
					<div>
						<input type='hidden' value="<?php echo $task; ?>" name="task" />
						
						<input type='hidden' value="<?php echo $employeeIDOrig; ?>" name="employeeIDOrig" />
						
						<input type='hidden' value="<?php echo $oldDept; ?>" name="oldDept" />
					
						<input type="submit" name="updateEmployees" value="<?php echo (isset($task)) ? $task : 'UPDATE' ?>" />
					</div>
			
					<br/>
					
					
					
					
		  </form>	
					

					<?php 		//if EDIT show ADD dependents, if ADD dont
					if ($task == 'EDIT') 			
					{
					?>
					
					<!-- display dependents here -->
					<table border="1">
						
					<form method="post" action="updateDependents.php">
						<input type='hidden' value='ADD' name='task' />
						<input type='hidden' value='<?php echo $eID; ?>' name='eID' / >
						<input type="submit" value="ADD a Dependent" name="addDependent" />
					</form> <!--  end of dependent form -->
					
					<?php
							echo "<tr><td colspan='9'>";

									//---- show dependents --------
									
									$qDeps = "SELECT *
											  FROM Dependents
											  WHERE employeeID = '$eID';
											 ";
									//echo $qEmpID;
									
									$resultDeps = $conn->query($qDeps);	
									
									//echo "<div style='border: 1px red solid;'>";

									if ($resultDeps->num_rows > 0) {
										
										echo "<table border='1' class='depTable'>";
										
											//TABLE HEADINGS
											echo "<tr>";
												echo "<th>Dependent SIN</th>";
												echo "<th>Dependent Name</th>";
												echo "<th>Dependent DOB</th>";
												echo "<td>" .  $dummy . "</td>"; 
												echo "<td>" .  $dummy . "</td>"; 
											echo "</tr>";
											
											while ($rowDeps = $resultDeps->fetch_assoc()) 
											{
												//each tuple
												echo "<tr>";
													echo "<td>" . $rowDeps['dSIN'] . "</td>";
													echo "<td>" . $rowDeps['dName'] . "</td>";
													echo "<td>" . $rowDeps['dDateOfBirth'] . "</td>";
	

													//echo "<td><button>EDIT</button></td>";
													
													//<!--form method='post' action='updateDependents.php'-->
													//<!--/form-->
													
													echo "<td> <form method='post' action='updateDependents.php'>
														<input type='hidden' value='" . $rowDeps['dSIN']  . "' name='dSIN' / >
														<input type='hidden' value='EDIT' name='task' />  
														<input type='submit' value='EDIT' name='editDependent' />
														</form>
														
														</td>";
														
														//<--form method='post' action='updateDependents.php'-->
														//<!--/form-->
													echo "<td> <form method='post' action='deleteDependent.php'>
															<input type='hidden' value='" . $rowDeps['dSIN']  . "' name='dID' / >
															<input type='hidden' value='DELETE' name='task' />
															<input type='hidden' value='" . $eID . "' name='eID' /> 
															<input type='submit' value='DELETE' name='delDependent' />
															</form>
													</td>";								
													
												echo "</tr>";

											}
										
										echo  "</table>";		//end of dependent inner table
									}
									else
									{
										echo "NO dependents";
									}
							
							echo "</td></tr>";
					
					?>
					

					
					</table>	
					
					
					
					<?php } ?>
					
					
			 
        </div>
      </div>
	 
		
    </div>
	
<?php 
}
else
{ ?>

	<h2>Operations completed successfully!</h2>
	<!--h2><a href="index.php" />HOME</h2-->
	
<?php
}
?>


<!--------------------------------->

<?php 
//close DB connection, only do it after all php-mysql stuff are done
//put it at the end
//$conn->close();
?>



<h2><a href="index.php" />HOME</h2>

</body>


</html>