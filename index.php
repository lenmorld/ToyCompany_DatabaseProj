<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication


$mode = 'Employees';

if (isset($_POST['mode']))
	$mode = $_POST['mode'];

//############# TESTING CODE ########
echo '<br/>####### Testing code ######<br/>';
print_r($_POST);
echo '<br/>############################<br/>';


/*
POSTED vars

SEARCH DEPARTMENT
$_POST['searchDeptOption']   --> select option
$_POST['searchDeptText']   --> search text
$_POST['searchDeptButton']   --> button

$_POST['see_all_employee']	--> button to show all employees

$_POST['searchEmpOption']   --> select option
$_POST['searchEmpText']   --> search text
$_POST['searchEmpButton']   --> button


$_POST['searchCustOption']   --> select option
$_POST['searchCustText']   --> search text
$_POST['searchCustButton']   --> button

*/

if (isset($_POST['searchDeptOption']))
{
	$searchDeptOption = $_POST['searchDeptOption'];
	$searchDeptText = $_POST['searchDeptText'];
} 


if (isset($_POST['searchEmpOption']))
{
	$searchEmpOption = $_POST['searchEmpOption'];
	$searchEmpText = $_POST['searchEmpText'];
}


if (isset($_POST['searchCustOption']))
{
	$searchCustOption = $_POST['searchCustOption'];
	$searchCustText = $_POST['searchCustText'];
}


if (isset($_POST['searchDeptOption2']))
{
	$searchDeptOption2 = $_POST['searchDeptOption2'];
	$searchDeptText2 = $_POST['searchDeptText2'];
}


if (isset($_POST['searchItemOption']))
{
	$searchItemOption = $_POST['searchItemOption'];
	$searchItemText = $_POST['searchItemText'];
}

if (isset($_POST['searchInvOption']))
{
	$searchInvOption = $_POST['searchInvOption'];
	$searchInvText = $_POST['searchInvText'];
}

//DELETE EMPLOYEE
if (isset($_POST['delEmployee']))
{
	//DELETE employee
	$eID = $_POST['eID'];
	
		$qDelete = "DELETE 
					FROM Employees
				   WHERE employeeID='$eID' ;"  ;

		//echo $qEdit;
		
		if ($conn->query($qDelete) === TRUE) {
			echo "Employee deleted successfully";
			
			//header('Location: ./index.php');
			//exit;
		} else {
			echo "Error: " . $qDelete . "<br>" . $conn->error;
		}
}


//DELETE CUSTOMER
if (isset($_POST['delCustomer']))
{
		$cID = $_POST['cID'];
	
		$qDelete = "DELETE 
					FROM Customers
				   WHERE customerID='$cID' ;"  ;

		//echo $qEdit;
		
		if ($conn->query($qDelete) === TRUE) {
			echo "<br/>Customer deleted successfully<br />";
			
			//header('Location: ./index.php');
			//exit;
		} else {
			echo "<br/> Error: " . $qDelete . "<br>" . $conn->error;
		}
}


//DELETE DEPARTMENT
if (isset($_POST['delDepartment']))
{
		$dID = $_POST['dID'];
	
		$qDelete = "DELETE 
					FROM Department
				    WHERE departmentID='$dID' ;"  ;

		//echo $qEdit;
		
		if ($conn->query($qDelete) === TRUE) {
			echo "<br/>Department deleted successfully<br />";
			
			//header('Location: ./index.php');
			//exit;
		} else {
			echo "<br/> Error: " . $qDelete . "<br>" . $conn->error;
		}
}


//DELETE DEPARTMENT
if (isset($_POST['delItem']))
{
		$itemID = $_POST['itemID'];
	
		$qDelete = "DELETE 
					FROM Items
				    WHERE companyItemID='$itemID' ;"  ;

		//echo $qEdit;
		
		if ($conn->query($qDelete) === TRUE) {
			echo "<br/>Item deleted successfully<br />";
			
			//header('Location: ./index.php');
			//exit;
		} else {
			echo "<br/> Error: " . $qDelete . "<br>" . $conn->error;
		}
}




?>

<HTML>
<HEAD>
  <TITLE>UMC 353-4 DEMO</TITLE>
  <style>
	body { font-family: "Arial", Sans-serif; color: limegreen; background-color: black; }
	.depTable { background-color: gray; margin-left: 100px;}
  </style>

</HEAD>
<BODY>

<hr>
	<h2>TOY COMPANY</h2><H3>UMC 353-4 DEMO - LENMOR, DEXTER, SIMON</H3>
<hr>
<!--DIV>
	The current date and time is
<EM><?echo date("D M d, Y H:i:s", time())?></EM>
</div-->

<ul>
	<li><a href="q1.php">Objective 1</a></li>
	<li><a href="q2.php">Objective 2</a></li>
	<li><a href="q3.php">Objective 3</a></li>
	<li><a href="q4.php">Objective 4</a></li>
	<li><a href="q5.php">Objective 5</a></li>
	<li><a href="q6.php">Objective 6</a></li>
</ul>


<form action="index.php" method="post">
  <input type="radio" name="mode" value="Employees"  <?php if ($mode=='Employees') echo 'checked';  ?> >Manage Employees<br>
  <input type="radio" name="mode" value="Customers"  <?php if ($mode=='Customers') echo 'checked';  ?>>Manage Customers<br>
  <input type="radio" name="mode" value="Departments"  <?php if ($mode=='Departments') echo 'checked';  ?>>Manage Departments<br>
  <input type="radio" name="mode" value="Orders"  <?php if ($mode=='Orders') echo 'checked';  ?>>Manage Orders<br>
  <input type="radio" name="mode" value="Items"  <?php if ($mode=='Items') echo 'checked';  ?>>Manage Items<br>
  <input type="radio" name="mode" value="Inventory"  <?php if ($mode=='Inventory') echo 'checked';  ?>>Manage Inventory<br>
  
  <br />
  <input type="submit" name="selectMode" value="SELECT MODE" />

</form>

<hr>

<!-- OBJECTIVE 1 entry point-->
<!--######################################################################-->
<!------ Objective 7 ------->


<?php if ($mode=='Employees')
{ ?>


<!---------------- EMPLOYEES INFO ---------------------->
<div id="manipulateEmployees" >
	
	<h3>Manage employees and dependents</h3>
	<!------ 1. search an employee / OR show all employees -------->
	<div>
	<!----------- show all employees ---------->
	<form method="post" action="index.php">
		<input type="hidden" value="Employees" name="mode" />
		<input type="submit" value="SEE ALL EMPLOYEES" name="see_all_employee" id="see_all_employee" />
		
	</form>

	<!---------- ADD EMPLOYEES --------->
	<!-- could be placed here or another page -->
	<!-- for noe put in another page for simpicity -->
	<div>
		<!--a href="addEmployee.php">Add Employee</a-->
		<!--button onclick="child_open()">ADD EMPLOYEE</button-->
		<!--a href="javascript:child_open()">Add Employee</a-->
		<form action="updateEmployee.php">
			<input type="hidden" value="Employees" name="mode" />
			<input type="submit" value="ADD EMPLOYEE">
			
		</form>
	</div>
	
	<!----------- search an employee ---------->
	<form method="post" action="index.php">

			<label>Search by:</label>
			<select name="searchEmpOption">
			  <option value="ID">ID</option>
			  <option value="name">Name</option>
			</select>
			
			<label for="searchEmpText">Search an employee</label>
			<input type="text" id="searchEmpText" name="searchEmpText" />
			<input type='hidden' value='Employees' name='mode' />
			
			<input type="submit" value="Search" name="searchEmpButton" id="searchEmpButton" />
			
	</form>

	<?php
	if ( $authenticated && (  isset($_POST['see_all_employee']) || isset($_POST['searchEmpButton']))   )  {

		//SHOW ALL EMPLOYEES
		if (isset($_POST['see_all_employee'])) {		// if verified see_employee button clicked do stuff here
			
			//formulate query for all employees
			$query = "SELECT *
						FROM Employees; ";
		}	// SEARCH Employees
		else if (isset($searchEmpOption)) {
		
			//if its employee name, get employeeID
			if ($searchEmpOption == 'name')
				{	
					$qEmpID = "SELECT employeeID
							  FROM Employees
							  WHERE eName LIKE '%$searchEmpText%';
							";
					echo $qEmpID;
					
					$resultEmpID = $conn->query($qEmpID);	

					if ($resultEmpID->num_rows > 0) {
						$rowEID = $resultEmpID->fetch_assoc();
						echo $row['employeeID'];
						$employeeID = $rowEID['employeeID'];
					}
				}
				else { 			//else $searchEmpText is the Employee ID
					$employeeID  = $searchEmpText;
				}		

			//formulate query
			$query = "SELECT * 
					  FROM Employees
					  WHERE employeeID LIKE '%$employeeID'  ;";
		}

		//run query
		$result = $conn->query($query);
		
		//check if there is at least 1 result
		if ($result->num_rows > 0) {
		
		echo "<table border='1'>";
		
			//TABLE HEADINGS
			echo "<tr>";
				echo "<th>Employee ID</th>";
				echo "<th>SIN</th>";
				echo "<th>Name</th>";
				echo "<th>DOB</th>";
				echo "<th>Position</th>";
				echo "<th>Address</th>";
				echo "<th>Telephone</th>";
				echo "<th>" .  $dummy . "</th>"; 
				echo "<th>" .  $dummy . "</th>"; 
			echo "</tr>";
		
			// output data of each row
			while($row = $result->fetch_assoc()) {
			
				$eID = $row['employeeID'];
				
				//print_r( $row );
				//each tuple
				
				echo "<tr>";
							//echo "<div style='border: 1px blue solid;'>";
					
							//echo "<td><input type='text' value='" . $eID . "' name='eID' disabled/></td>";
							echo"<td>" . $eID . "</td>";
							echo"<td>" . $row['eSIN'] . "</td>";
							echo "<td>" . $row['eName'] . "</td>";
							echo "<td>" . $row['eDateOfBirth'] . "</td>";
							echo "<td>" . $row['position'] . "</td>";
							echo "<td>" . $row['address'] . "</td>";
							echo "<td>" . $row['telephone'] . "</td>";

							//echo "<td><button onclick='child_open()'>EDIT</button></td>";
							
							//echo "<td> <a href='javascript:child_open()'>EDIT</a>  </td>";
							
							echo "<td> <form method='post' action='updateEmployee.php'>
									<input type='hidden' value='" . $eID  . "' name='eID' / >
									<input type='hidden' value='Employees' name='mode' />
									<input type='hidden' value='EDIT' name='task' />  
									<input type='submit' value='EDIT' />							
									</form>
							</td>";
							
							//echo "<td><button>DELETE</button></td>";
							echo "<td> <form method='post' action='index.php'>
									<input type='hidden' value='" . $eID  . "' name='eID' / >
									<input type='hidden' value='Employees' name='mode' />
									<input type='submit' value='DELETE' name='delEmployee' />
									</form>
							</td>";
							
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
												//echo "<td>" .  $dummy . "</td>"; 
												//echo "<td>" .  $dummy . "</td>"; 
											echo "</tr>";
									
											while ($rowDeps = $resultDeps->fetch_assoc()) 
											{
												//each tuple
												echo "<tr>";
													echo "<td>" . $rowDeps['dSIN'] . "</td>";
													echo "<td>" . $rowDeps['dName'] . "</td>";
													echo "<td>" . $rowDeps['dDateOfBirth'] . "</td>";
	

													//echo "<td><button>EDIT</button></td>";
													//echo "<td><button>DELETE</button></td>";
												echo "</tr>";

											}
										
										echo  "</table>";		//end of dependent inner table
									}
							
							echo "</td></tr>";
					
					//echo "</div>";
					
					//echo "</div>";
				echo "</tr>";		// end of current employee info
			}
			
		echo "</table>";			//end of employee table	
			
		} else {
			echo "0 results";
		}	

		}
	?>
	
	<hr>
	
	</div>

	 <!-- END OF 1. search an employee / OR show all employees -------->
</div>




<!------------------------->


<?php
}
else if ($mode=='Customers')
{ ?>



<div id="manipulateCustomers">
	
	
	<h3>Manage Customers</h3>
	<!--  2. search customer ** ADD/EDIT/DELETE -->
	<div>
	<!----------- show all customers ---------->
	<form method="post" action="index.php">
		<input type='hidden' value='Customers' name='mode' />
		<input type="submit" value="SEE ALL CUSTOMERS" name="see_all_customers" id="see_all_customers" />
	</form>

	<!---------- ADD CUSTOMERS --------->
	<!-- could be placed here or another page -->
	<!-- for now put in another page for simpicity -->
	<div>
		<!--a href="addCustomers.php">Add Employee</a-->
		<!--button onclick="child_open2()">ADD CUSTOMER</button-->
		<!--a href="javascript:child_open()">Add Employee</a-->
		<form action="updateCustomer.php">
			<input type='hidden' value='Customers' name='mode' />
			<input type="submit" value="ADD CUSTOMER">
		</form>
	</div>
	
	<!----------- search a customer ---------->
	<form method="post" action="index.php">


		
			<label>Search by:</label>
			<select name="searchCustOption">
			  <option value="ID">ID</option>
			  <option value="name">Name</option>
			</select>
			
			<label for="searchCustText">Search a customer</label>
			<input type="text" id="searchCustText" name="searchCustText" />
			
			<input type='hidden' value='Customers' name='mode' />
			
			<input type="submit" value="Search" name="searchCustButton" id="searchCustButton" />
			
	</form>

	<?php
	if ( $authenticated && (  isset($_POST['see_all_customers']) || isset($_POST['searchCustButton']))   )  {

		//SHOW ALL CUST
		if (isset($_POST['see_all_customers'])) {		// if verified see_customers button clicked do stuff here
			
			//formulate query for all employees
			$query = "SELECT *
						FROM Customers; ";
		}	// SEARCH Customers
		else if (isset($searchCustOption)) {
		
			//if its customer name, get customer ID
			if ($searchCustOption == 'name')
				{	
					$qCustID = "SELECT customerID
							  FROM Customers
							  WHERE cName LIKE '%$searchCustText%';
							";
					echo $qCustID;
					
					$resultCustID = $conn->query($qCustID);	

					if ($resultCustID->num_rows > 0) {
						$rowCID = $resultCustID->fetch_assoc();
						//echo $row['customerID'];
						$customerID = $rowCID['customerID'];
					}
				}
				else { 			//else $searchEmpText is the Employee ID
					$customerID  = $searchCustText;
				}		

			//formulate query
			$query = "SELECT * 
					  FROM Customers
					  WHERE customerID = '$customerID'  ;";
		}

		//run query
		$result = $conn->query($query);
		
		//check if there is at least 1 result
		if ($result->num_rows > 0) {
		
		echo "<table border='1'>";
		
			//TABLE HEADINGS
			echo "<tr>";
				echo "<th>Customer ID</th>";
				echo "<th>Name</th>";
				echo "<th>Address</th>";
				echo "<th>Telephone</th>";
				echo "<th>" .  $dummy . "</th>"; 
				echo "<th>" .  $dummy . "</th>"; 
			echo "</tr>";
		
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$cID = $row['customerID'];
				
				//print_r( $row );
				//each tuple
				
				echo "<tr>";
							//echo "<div style='border: 1px blue solid;'>";
					
							//echo "<td><input type='text' value='" . $cID . "' name='cID' disabled/></td>";
							echo"<td>" . $cID . "</td>";
							echo "<td>" . $row['cName'] . "</td>";
							echo "<td>" . $row['cAddress'] . "</td>";
							echo "<td>" . $row['cTelephone'] . "</td>";

							//echo "<td><button onclick='child_open()'>EDIT</button></td>";
							//echo "<td> <a href='javascript:child_open()'>EDIT</a>  </td>";
							
							echo "<td> <form method='post' action='updateCustomer.php'>
									<input type='hidden' value='" . $cID  . "' name='cID' / >
									<input type='hidden' value='Customers' name='mode' />
									<input type='hidden' value='EDIT' name='task' />  
									<input type='submit' value='EDIT' />
									</form>
							</td>";
							
							//echo "<td><button>DELETE</button></td>";
							echo "<td> <form method='post' action='index.php'>
									<input type='hidden' value='" . $cID  . "' name='cID' / >
									<input type='hidden' value='Customers' name='mode' />
									<input type='submit' value='DELETE' name='delCustomer' />
									</form>
							</td>";
					
					//echo "</div>";
					
					//echo "</div>";
				echo "</tr>";		// end of current customer info
			}
			
		echo "</table>";			//end of customer table	
		} else {
			echo "0 results";
		}	

		}
	?>
	
	<hr>

	 <!-- END OF 2. search a customer / OR show all customers -------->	
	</div>
</div>	

	
	
<!------------------------->


<?php
}
else if ($mode=='Departments')
{ ?>

	
<div id="manipulateDepartments">
	
	<h3>Manage Departments</h3>
		<!--  3. search Department ** ADD/EDIT/DELETE -->
	<div>
	<!----------- show all departments ---------->
	<form method="post" action="index.php">
		<input type='hidden' value='Departments' name='mode' />
		<input type="submit" value="SEE ALL DEPARTMENTS" name="see_all_departments2" id="see_all_departments2" />
	</form>

	<!---------- ADD A DEPARTMENT  --------->
	<!-- could be placed here or another page -->
	<!-- for now put in another page for simpicity -->
	<div>
		<!--a href="addDepartments.php">Add Employee</a-->
		<!--button onclick="child_open2()">ADD Department</button-->
		<!--a href="javascript:child_open()">Add Employee</a-->
		<form action="updateDepartment.php">
			<input type='hidden' value='Departments' name='mode' />
			<input type="submit" value="ADD DEPARTMENT">
		</form>
	</div>
	
	<!----------- search a department ---------->
	<form method="post" action="index.php">

			
		
			<label>Search by:</label>
			<select name="searchDeptOption2">
			  <option value="ID">ID</option>
			  <option value="name">Name</option>
			</select>
			
			<label for="searchDeptText2">Search a Department</label>
			<input type="text" id="searchDeptText2" name="searchDeptText2" />
			
			<input type='hidden' value='Departments' name='mode' />
			
			<input type="submit" value="Search" name="searchDeptButton2" id="searchDeptButton2" />
			
	</form>

	<?php
	if ( $authenticated && (  isset($_POST['see_all_departments2']) || isset($_POST['searchDeptButton2']))   )  {

		//SHOW ALL CUST
		if (isset($_POST['see_all_departments2'])) {		// if verified see_departments button clicked do stuff here
			
			//formulate query for all employees
			$query = "SELECT *
						FROM Department; ";
		}	// SEARCH Departments
		else if (isset($searchDeptOption2)) {
		
			//if its department name, get department ID
			if ($searchDeptOption2 == 'name')
				{	
					$qDeptID = "SELECT departmentID
							  FROM Department
							  WHERE deptName LIKE '%$searchDeptText2%';
							";
					//echo $qDeptID;
					
					$resultDeptID = $conn->query($qDeptID);	
	
					
					if ($resultDeptID->num_rows > 0) {
						
						$rowDID = $resultDeptID->fetch_assoc();
						//echo $row['departmentID'];
						$departmentID = $rowDID['departmentID'];
						
					}
				}
				else { 			//else $searchEmpText is the Employee ID
					$departmentID  = $searchDeptText2;
				}		

			//formulate query
			$query = "SELECT * 
					  FROM Department
					  WHERE departmentID = '$departmentID'  ;";
			
				  
		}

		//echo $query;
		//run query
		$result = $conn->query($query);
		
		//check if there is at least 1 result
		if ($result->num_rows > 0) {
		
		echo "<table border='1'>";
		
			//TABLE HEADINGS
			echo "<tr>";
				echo "<th>Department ID</th>";
				echo "<th>Name</th>";
				echo "<th>Room Number</th>";
				echo "<th>Fax Number</th>";
				echo "<th>Tel 1</th>";
				echo "<th>Tel 2</th>";
				echo "<th>" .  $dummy . "</th>"; 
				echo "<th>" .  $dummy . "</th>"; 
			echo "</tr>";
		
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$dID = $row['departmentID'];
				
				//print_r( $row );
				//each tuple
				
				echo "<tr>";
							//echo "<div style='border: 1px blue solid;'>";
					
							//echo "<td><input type='text' value='" . $cID . "' name='cID' disabled/></td>";
							echo"<td>" . $dID . "</td>";
							echo "<td>" . $row['deptName'] . "</td>";
							echo "<td>" . $row['roomNumber'] . "</td>";
							echo "<td>" . $row['faxNumber'] . "</td>";
							echo "<td>" . $row['phoneNumber1'] . "</td>";
							echo "<td>" . $row['phoneNumber2'] . "</td>";

							//echo "<td><button onclick='child_open()'>EDIT</button></td>";
							//echo "<td> <a href='javascript:child_open()'>EDIT</a>  </td>";
							
							echo "<td> <form method='post' action='updateDepartment.php'>
									<input type='hidden' value='" . $dID  . "' name='dID' / >
									<input type='hidden' value='EDIT' name='task' />
									<input type='hidden' value='Departments' name='mode' />
									<input type='submit' value='EDIT' />
									</form>
							</td>";
							
							//echo "<td><button>DELETE</button></td>";
							echo "<td> <form method='post' action='index.php'>
									<input type='hidden' value='" . $dID  . "' name='dID' / >
									<input type='hidden' value='Departments' name='mode' />
									<input type='submit' value='DELETE' name='delDepartment' />
									</form>
							</td>";
					
					//echo "</div>";
					
					//echo "</div>";
				echo "</tr>";		// end of current department info
			}
			
		echo "</table>";			//end of department table	
		} else {
			echo "0 results";
		}	

		}
	?>
	
	<hr>

	 <!-- END OF 3.  DEPARTMENTS -------->	
	</div>
</div>	

	
	
	
<!------------------------->
	

<?php
}
else if ($mode=='Orders')
{ ?>


<div id="manipulateOrders">
	
	<h3>Manage Orders</h3>
	<!--  4. search ORDERS ** ADD/EDIT/DELETE -->
	<div>
	<!----------- show all orders ---------->
	<form method="post" action="index.php">
		<input type='hidden' value='Orders' name='mode' />
		<input type="submit" value="SEE ALL ORDERS" name="see_all_orders" id="see_all_orders" />
	</form>

	<!---------- ADD A ORDERS  --------->
	<!-- could be placed here or another page -->
	<!-- for now put in another page for simpicity -->
	<div>
		<!--a href="addOrderss.php">Add Employee</a-->
		<!--button onclick="child_open2()">ADD Orders</button-->
		<!--a href="javascript:child_open()">Add Employee</a-->
		<form action="addOrder.php">
			<input type='hidden' value='Orders' name='mode' />
			<input type="submit" value="ADD AN ORDER">
		</form>
	</div>
	
	<!----------- search a order ---------->
	<form method="post" action="index.php">

			
		
			<label>Search by:</label>
			<!--select name="searchOrderOption">
			  <option value="oID">Order ID</option>
			  <option value="cID">Customer ID</option>
			</select-->
			
			<label for="searchOrderID">Order ID</label>
			<input type="text" id="searchOrderID" name="searchOrderID" />
			
			<label for="searchCustID">Customer ID</label>
			<input type="text" id="searchCustID" name="searchCustID" />
			<input type='hidden' value='Orders' name='mode' />
			
			<input type="submit" value="Search" name="searchOrderButton" id="searchOrderButton" />
			
	</form>

	<?php
	if ( $authenticated && (  isset($_POST['see_all_orders']) || isset($_POST['searchOrderButton']))   )  {
		
		
		$searchOrderID = $_POST['searchOrderID'];
		$searchCustID = $_POST['searchCustID'];

		//SHOW ALL CUST
		if (isset($_POST['see_all_orders'])) {		// if verified see_orders button clicked do stuff here
			
			//formulate query for all employees
			$query = "SELECT *
						FROM Orders; ";
		}	//only custID given
		else if ( $searchOrderID == '' && $searchCustID != '') {
			
			$query = "SELECT *
						FROM Orders
						WHERE customerID LIKE '%$searchCustID%' ; ";

		}  //both given
		else if ( $searchOrderID != '' && $searchCustID != '') {

			$query = "SELECT *
						FROM Orders
						WHERE customerID LIKE '%$searchCustID%' AND orderID LIKE '%$searchOrderID%' ; ";
		
		}
		else
		{
			echo "<br/>Error, must search by CustomerID and OrderID, or CustomerID alone";
			exit;
		}

		//echo $query;
		//run query
		$result = $conn->query($query);
		
		//check if there is at least 1 result
		if ($result->num_rows > 0) {
		
		echo "<table border='1'>";
		
			//TABLE HEADINGS
			echo "<tr>";
				echo "<th>Order ID</th>";
				echo "<th>CustomerID</th>";
				echo "<th>Date</th>";
				echo "<th>" .  $dummy . "</th>"; 
				echo "<th>" .  $dummy . "</th>"; 
			echo "</tr>";
		
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$oID = $row['orderID'];
				$cID = $row['customerID'];
				
				//print_r( $row );
				//each tuple
				
				echo "<tr>";
							//echo "<div style='border: 1px blue solid;'>";
					
							//echo "<td><input type='text' value='" . $cID . "' name='cID' disabled/></td>";
							echo"<td>" . $oID . "</td>";
							echo"<td>" . $cID . "</td>";
							echo "<td>" . $row['dateOfOrder'] . "</td>";


							//echo "<td><button onclick='child_open()'>EDIT</button></td>";
							//echo "<td> <a href='javascript:child_open()'>EDIT</a>  </td>";
							
							echo "<td> <form method='post' action='updateOrder.php'>
									<input type='hidden' value='" . $oID  . "' name='oID' / >
									<input type='hidden' value='" . $cID  . "' name='cID' / >
									<input type='hidden' value='Orders' name='mode' />
									<input type='hidden' value='EDIT' name='task' />  
									<input type='submit' value='EDIT' />
									</form>
							</td>";
							
							//echo "<td><button>DELETE</button></td>";
							echo "<td> <form method='post' action='index.php'>
									<input type='hidden' value='" . $oID  . "' name='oID' / >
									<input type='hidden' value='" . $cID  . "' name='cID' / >
									<input type='hidden' value='Orders' name='mode' />
									<input type='submit' value='DELETE' name='delOrders' />
									</form>
							</td>";
					
					//echo "</div>";
					
					//echo "</div>";
				echo "</tr>";		// end of current order info
			}
			
		echo "</table>";			//end of order table	
		} else {
			echo "0 results";
		}	

		}
	?>
	
	<hr>

	 <!-- END OF 4.  ORDERS ------->	
	</div>
	
</div>


<!------------------------->


<?php
}
else if ($mode=='Items')
{ ?>


<div id="manipulateItems">
	<h3>Manage Items</h3>
		<!--  7.e search Items ** ADD/EDIT/DELETE -->

	<!----------- show all items---------->
	<form method="post" action="index.php">
		<input type='hidden' value='Items' name='mode' />
		<input type="submit" value="SEE ALL ITEMS" name="see_all_items" id="see_all_items" />
	</form>

	<!---------- ADD AN ITEMS  --------->
	<!-- could be placed here or another page -->
	<!-- for now put in another page for simpicity -->
	<div>
		<!--a href="addDepartments.php">Add Employee</a-->
		<!--button onclick="child_open2()">ADD Department</button-->
		<!--a href="javascript:child_open()">Add Employee</a-->
		<form action="updateItem.php">
			<input type='hidden' value='Items' name='mode' />
			<input type="submit" value="ADD ITEM">
		</form>
	</div>
	
	<!----------- search an item ---------->
	<form method="post" action="index.php">

			<label>Search by:</label>
			<select name="searchItemOption">
			  <option value="ID">ID</option>
			  <option value="name">Name</option>
			</select>
			
			<label for="searchItemText">Search an Item</label>
			<input type="text" id="searchItemText" name="searchItemText" />
			<input type='hidden' value='Items' name='mode' />
			
			<input type="submit" value="Search" name="searchItemButton" id="searchItemButton" />
			
	</form>

	<?php
	if ( $authenticated && (  isset($_POST['see_all_items']) || isset($_POST['searchItemButton']))   )  {

			//SHOW ALL CUST
			if (isset($_POST['see_all_items'])) {		// if verified see_departments button clicked do stuff here
				$query = "SELECT *
							FROM Items; ";
			}	// SEARCH Items
			else if (isset($searchItemOption)) {
				//if its department name, get department ID
				
				echo $searchItemOption;
				
				if ($searchItemOption == 'name')
					{	
						$qItemID = "SELECT companyItemID
								  FROM Items
								  WHERE name LIKE '%$searchItemText%';
								";
						//echo $qItemID;
						
						$resultItemID = $conn->query($qItemID);	
		
						
						if ($resultItemID->num_rows > 0) {
							
							$rowDID = $resultItemID->fetch_assoc();
							//echo $row['departmentID'];
							$companyItemID = $rowDID['companyItemID'];
						}
					}
					else { 			//else search text is the ID
						$companyItemID  = $searchItemText;
					}		
	
				//formulate query
				$query = "SELECT * 
						  FROM Items
						  WHERE companyItemID LIKE '%$companyItemID'  ;";		 
			}
			//echo $query;
			//run query
			$result = $conn->query($query);
			
			//check if there is at least 1 result
			if ($result->num_rows > 0) {
			
			echo "<table border='1'>";
			
				//TABLE HEADINGS
				echo "<tr>";
					echo "<th>Item ID</th>";
					echo "<th>Name</th>";
					echo "<th>Num of Color</th>";
					echo "<th>" .  $dummy . "</th>"; 
					echo "<th>" .  $dummy . "</th>"; 
				echo "</tr>";
			
				// output data of each row
				while($row = $result->fetch_assoc()) {
					
					
					//print_r( $row );
					//each tuple
					
					echo "<tr>";
								//echo "<div style='border: 1px blue solid;'>";
						
								//echo "<td><input type='text' value='" . $cID . "' name='cID' disabled/></td>";
								echo"<td>" . $row['companyItemID'] . "</td>";
								echo "<td>" . $row['name'] . "</td>";
								echo "<td>" . $row['numOfColor'] . "</td>";
	
	
								//echo "<td><button onclick='child_open()'>EDIT</button></td>";
								//echo "<td> <a href='javascript:child_open()'>EDIT</a>  </td>";
								
								echo "<td> <form method='post' action='updateItem.php'>
										<input type='hidden' value='" .  $row['companyItemID']  . "' name='itemID' / >
										<input type='hidden' value='EDIT' name='task' />
										<input type='hidden' value='Items' name='mode' />
										<input type='submit' value='EDIT' />
										</form>
								</td>";
								
								//echo "<td><button>DELETE</button></td>";
								echo "<td> <form method='post' action='index.php'>
										<input type='hidden' value='" . $row['companyItemID']  . "' name='itemID' / >
										<input type='submit' value='DELETE' name='delItem' />
										<input type='hidden' value='Items' name='mode' />
										</form>
								</td>";
						
						//echo "</div>";
						
						//echo "</div>";
					echo "</tr>";		// end of current department info
				}
				
			echo "</table>";			//end of department table	
			} else {
				echo "0 results";
			}	

		}
	?>
	
	<hr>

		<!-- END OF 7.e Items-------->	
	   
</div>	



<!------------------------->


<?php
}
else if ($mode=='Inventory')
{ ?>


<div id="manipulateInventory">
	<h3>Manage Inventory Items</h3>
		<!--  7.e search Inventory ** ADD/EDIT/DELETE -->
	<div>
	<!----------- show all items---------->
	<form method="post" action="index.php">
		<input type='hidden' value='Inventory' name='mode' />
		<input type="submit" value="SEE ALL INVENTORY ITEMS" name="see_all_inv" id="see_all_inv" />
	</form>

	<!---------- ADD AN ITEM IN INV  --------->
	<div>
		<!--a href="addDepartments.php">Add Employee</a-->
		<!--button onclick="child_open2()">ADD Department</button-->
		<!--a href="javascript:child_open()">Add Employee</a-->
		<form action="updateInv.php">
			<input type='hidden' value='Inventory' name='mode' />
			<input type="submit" value="ADD ITEM">
		</form>
	</div>
	
	<!----------- search a department ---------->
	<form method="post" action="index.php">

			
		
			<label>Search by:</label>
			<select name="searchInvOption">
			  <option value="ID">ID</option>
			  <option value="name">Name</option>
			</select>
			
			<label for="searchInvText">Search an Item</label>
			<input type="text" id="searchInvText" name="searchInvText" />
			<input type='hidden' value='Inventory' name='mode' />
			
			<input type="submit" value="Search" name="searchInvButton" id="searchInvButton" />
			
	</form>

	<?php
	if ( $authenticated && (  isset($_POST['see_all_inv']) || isset($_POST['searchInvButton']))   )  {

		//SHOW ALL CUST
		if (isset($_POST['see_all_inv'])) {		// if verified see_departments button clicked do stuff here
			$query = "SELECT *
						FROM Inventory; ";
		}	// SEARCH Items
		else if (isset($searchInvOption)) {
			
			//############ TODO FOR INV ##########
			
			//if its department name, get department ID
			if ($searchInvOption == 'name')
				{	
					$qItemID = "SELECT companyItemID
							  FROM Items
							  WHERE name LIKE '%$searchInvText%';
							";
					//echo $qDeptID;
					
					$resultItemID = $conn->query($qItemID);	
	
					
					if ($resultItemID->num_rows > 0) {
						
						$rowDID = $resultItemID->fetch_assoc();
						//echo $row['departmentID'];
						$companyItemID = $rowDID['companyItemID'];
					}
				}
				else { 			//else $searchEmpText is the Employee ID
					$companyItemID  = $searchInvText;
				}		

			//formulate query
			$query = "SELECT * 
					  FROM Inventory
					  WHERE companyItemID LIKE '%$companyItemID%'  ;";	  
		}
		
		echo $query;
		//run query
		$result = $conn->query($query);
		
		//check if there is at least 1 result
		if ($result->num_rows > 0) {
		
		echo "<table border='1'>";
		
			//TABLE HEADINGS
			echo "<tr>";
				echo "<th>Item ID</th>";
				echo "<th>Date of Manufacture</th>";
				echo "<th>Unit Price</th>";
				echo "<th>Quantity</th>";
				echo "<th>" .  $dummy . "</th>"; 
				echo "<th>" .  $dummy . "</th>"; 
			echo "</tr>";
		
			// output data of each row
			while($row = $result->fetch_assoc()) {
				
				
				//print_r( $row );
				//each tuple
				
				echo "<tr>";
							//echo "<div style='border: 1px blue solid;'>";
					
							//echo "<td><input type='text' value='" . $cID . "' name='cID' disabled/></td>";
							
							echo"<td>" . $row['companyItemID'] . "</td>";
							echo"<td>" . $row['dateOfManufacture'] . "</td>";
							echo"<td>" . $row['unitPrice'] . "</td>";
							echo "<td>" . $row['iQuantity'] . "</td>";


							//echo "<td><button onclick='child_open()'>EDIT</button></td>";
							//echo "<td> <a href='javascript:child_open()'>EDIT</a>  </td>";
							
							echo "<td> <form method='post' action='updateInv.php'>
									<input type='hidden' value='" .  $row['companyItemID']  . "' name='itemID' / >
									<input type='hidden' value='EDIT' name='task' />
									<input type='hidden' value='Inventory' name='mode' />
									<input type='submit' value='EDIT' />
									</form>
							</td>";
							
							//echo "<td><button>DELETE</button></td>";
							echo "<td> <form method='post' action='index.php'>
									<input type='hidden' value='" . $row['companyItemID']  . "' name='itemID' / >
									<input type='hidden' value='Inventory' name='mode' />
									<input type='submit' value='DELETE' name='delItem' />
									</form>
							</td>";
					
					//echo "</div>";
					
					//echo "</div>";
				echo "</tr>";		// end of current department info
			}
			
		echo "</table>";			//end of department table	
		} else {
			echo "0 results";
		}	

		}
	?>
	
	<hr>

	 <!-- END OF 7.e Items-------->	
	</div>
</div>	


<!------------------------->


<?php
}  ?>


<?php 
//close DB connection, only do it after all php-mysql stuff are done
//put it at the end
$conn->close();
?>

</BODY>
</HTML>