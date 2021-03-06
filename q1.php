<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication


if (isset($_POST['searchDeptOption']))
{
	$searchDeptOption = $_POST['searchDeptOption'];
	$searchDeptText = $_POST['searchDeptText'];
}


?>
<HTML>
<HEAD>
  <TITLE>UMC 353-4 DEMO - Q1</TITLE>
  
  <style>
	body { font-family: "Arial", Sans-serif; color: limegreen; background-color: black; }
	.depTable { background-color: gray; margin-left: 100px;}
  </style>

</HEAD>


<body>
    

<!---- Objective 1 ----->
<!--- search departments (by code or name, print out details about employee of that department                   -->

<div id="objective1">
<hr>
<form method="post" action="q1.php">
	
	<h3>Search a department</h3>
	<h5>*Objective 1</h5>
	
	<label>Search by:</label>
	<select name="searchDeptOption">
	  <option value="code">Code</option>
	  <option value="name">Name</option>
	</select>
	
	<label for="searchDeptText">Search a department</label>
	<input type="text" id="searchDeptText" name="searchDeptText" />
	
	<input type="submit" name="searchDeptButton" value="Search" />
	
</form>

<!----- put results of the search dept here ---->
<div id="">

<table border="1">
	<?php
		if ($authenticated && isset($_POST['searchDeptButton'])) {		// if verified see_employee button clicked do stuff here
			
			/*
				1. get department ID given the dept Name
				2. get all employees for given dept ID
					for each employee
					a. get employee ID and Name
					b. get Status by checking if employee is in FullTimer or PartTimer table
					c. get earnings per month
							- full timer get directly from  FullTimer tables
							- part timer, get numOfHours worked from WeeklyHistory * salary from PartTime table * 4    
					d. get number of dependents by counting dependents for each employee
				
			*/

			//if its department name, get departmentID
			if ($searchDeptOption == 'name')
				{	
					$query = "SELECT departmentID
							  FROM Department
							  WHERE deptName = '$searchDeptText';
							";
					//echo $query;
					
					$result = $conn->query($query);	

					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo $row['departmentID'];
						$departmentID = $row['departmentID'];
					}
				}
				else { 			//else $searchDeptText is the Dept ID
					$departmentID  = $searchDeptText;
				}

			echo "<br>";
			echo "<h3>Employees working on $departmentID:</h3>";
			
			//first get all employees for a given dept
			$query = "SELECT *
						FROM Employees
						WHERE Employees.employeeID
							IN (SELECT employeeID
								FROM WorksFor
								WHERE WorksFor.departmentID = '$departmentID'
								AND WorksFor.endDate IS NULL) ";
			//echo $query;
			$result = $conn->query($query);
			
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$eID = $row['employeeID'];			//######## employeeID
					$eName = $row['eName'];				//######## employeeName
					
					
						//get status of employee
						$qStatus = "SELECT employeeID, salary
									FROM FullTimerEmployees
									WHERE employeeID = '$eID'";
							echo $qStatus;
							$resultStatus = $conn->query($qStatus);
							
							echo $resultStatus ->num_rows;
							
							//if there's 1 result, this guy is in Full Times table
							if ($resultStatus ->num_rows > 0)  {		
								$rowS = $resultStatus ->fetch_assoc();
								$status = 'Full Time';							//########## status
								$salary =  $rowS['salary'];						//######### salary
							}
							else {	//this guy is Part Time

									$qPartTimeSalary = "SELECT salary
									FROM PartTimerEmployees
									WHERE employeeID = '$eID'";
				
									$resultPT = $conn->query($qPartTimeSalary);
				
								if ($resultPT->num_rows > 0)  {		
									$rowPT = $resultPT->fetch_assoc();
									
									$status = 'Part Time';													//########## status
									
									$qNumOfHoursPT = "SELECT numOfHours
									FROM WeeklyHistory
									WHERE employeeID = '$eID'";
				
									$resultHoursPT = $conn->query($qNumOfHoursPT);
									$rowHoursPT = $resultHoursPT->fetch_assoc();
		
									$salary =  $rowPT['salary'] * $rowHoursPT['numOfHours'] * 4.00;			//######### salary
								}	
							}	
						$qNumDep = "SELECT COUNT(*) AS NumDep										
									FROM Dependents
									WHERE employeeID = '$eID'	";
									
						$resultNumDep = $conn->query($qNumDep);
						
						if ($resultNumDep->num_rows > 0)  {		
							$rowNumDep = $resultNumDep->fetch_assoc();
							
							$numDep = $rowNumDep['NumDep'];												//######### number of dependents
						}

							
					//PRINT GATAHERED RESULTS
					

					//TABLE HEADINGS
					echo "<tr>";
						echo "<th>Employee ID</th>";
						echo "<th>Name</th>";
						echo "<th>Status</th>";
						echo "<th>Earnings per month</th>";
						echo "<th>Number of dependents</th>";
					echo "</tr>";
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $row['employeeID'] . "</td>";
						echo "<td>" . $row['eName'] . "</td>";
						echo "<td>" . $status . "</td>";
						echo "<td>" . $salary . "</td>";
						echo "<td>" . $numDep . "</td>";

						echo "<td><!--button>EDIT</button--></td>";
						echo "<td><!--button>DELETE</button--></td>";
					echo "</tr>";
				}
			} else {
				echo "<br>0 results";
			} 	
		}
	?>

</table>

</div>


</div>

<hr>


<?php 
//close DB connection, only do it after all php-mysql stuff are done
//put it at the end
$conn->close();
?>
<h5><a href="index.php" >HOME</a></h5>
</body>

</html>
