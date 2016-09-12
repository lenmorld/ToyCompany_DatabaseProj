<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication

if (isset($_POST['addEmployees'])) {
	//$ID = $_POST['ID'];
	$eSIN = $_POST['eSIN'];
	$eName = $_POST['eName'];
	$eDOB = $_POST['eDOB'];
	$ePosition = $_POST['ePosition'];
	$eAddress = $_POST['eAddress'];
	$eTel = $_POST['eTel'];
	
	//query to get max employee# plus 1
	$qNextID = "SELECT MAX(employeeID) AS max FROM Employees;";
	
	$resultNextID = $conn->query($qNextID);	

	if ($resultNextID->num_rows > 0) {
		$rowNID = $resultNextID->fetch_assoc();
		echo $rowNID['max'];
		$eID = $rowNID['max'];
		$eID++;
	}

	$qAdd = "INSERT INTO Employees(employeeID, eSIN, eName, eDateOfBirth, position, address, telephone)
				VALUES('$eID' , '$eSIN', '$eName', '$eDOB', '$ePosition', '$eAddress', '$eTel' );";
				
	echo $qAdd;
	
	if ($conn->query($qAdd) === TRUE) {
    echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$conn->close();
	
}

?>

<html>

<head>
	<title>Add Employees UMC-353-4</title>
	
	<link rel="stylesheet" href="css/add.css" type="text/css">

</head>

<body>

<!--------- add employee form ------>


 <div class="main">
 
 <form method="post" action="updateEmployee.php">

      <div class="one">
        <div class="register">
          <h3>Add an employee</h3>
          <form id="reg-form">
            <div>
              <label for="ID">Employee ID</label>
              <input type="text" id="ID" name="ID" placeholder="ETMC-000000" value=""/>
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
              <input type="date" name="eDOB" id="eDOB" placeholder="1990-12-14" value="<?php if (isset($eDOB)) echo $eDOB; ?>"/>
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
			
            <div>
				<input type="submit" value="ADD" name="addEmployees" />
            </div>

        </div>
      </div>
	 
		</form>	 
    </div>
	



<!--------------------------------->

</body>


</html>