<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication

//############# TESTING CODE ########
//echo '<br/>####### Testing code ######<br/>';
print_r($_POST);
//echo '<br/>############################<br/>';

/*
 *1. have user select from list of Customer ID
 *	if not add new customer
 *
 *2. load orders for customer
 *
 *
 *
 */

 if (isset($_POST['customer'])) {
	$customer = $_POST['customer'];
	$custID = $_POST['customer'];
}

//vars to track

if (isset($_POST['loadOrders']))
{
	$customer = $_POST['customer'];
	
	if ($customer == 'NONE')
	{
		echo "<br/>Please select a customer!";
	}
	else
	{
		$temp = explode(":", $customer);
		echo "<br/>" . $temp[0];
		
		$custID = $temp[0];
	}
}
else if (isset($_POST['addOrders'])) {

	$customer = $_POST['customer'];
	
	if ($customer == 'NONE')
	{
		echo "<br/>Please select a customer!";
	}
	else
	{
		$temp = explode(":", $customer);
		echo "<br/>" . $temp[0];
		
		$custID = $temp[0];
		//get max orderID for this Customer

		$qNextID = "SELECT MAX(A.orderID) AS max
					FROM  (SELECT orderID
							FROM Orders
							WHERE customerID='$custID') AS A ;";

		$resultNextID = $conn->query($qNextID);	
		
		//echo $qNextID;

		if ($resultNextID->num_rows > 0) {
			$rowOID = $resultNextID->fetch_assoc();
			//###### echo $rowCID['max'];
			$oID = $rowOID['max'];
			$oID++;
			//echo "MAX:" . $oID;
			
			if ($oID == '1')		//first one by this customer
			{
				$oID = "O-000-000-001";
			}
		}
	}
}

?>

<html>

<head>
	<title>Add/Edit/Delete Customer UMC-353-4</title>
	
	<link rel="stylesheet" href="css/add.css" type="text/css">

</head>

<body>


<form method="post" action="addOrder.php">

	<select name="customer">
		<option value="NONE">Select Customer</option>
		<?php
			//get all customers
	
			$qCInfo = "SELECT customerID, CONCAT(customerID, ':', cName) AS Customer
					  FROM Customers;";
	
			$resultCInfo = $conn->query($qCInfo);	
	
	
			if ($resultCInfo->num_rows > 0) {

			 
				while($rowC = $resultCInfo ->fetch_assoc()) {
				
							
					if ($customer == $rowC['customerID'])
						$str = ' selected';
					else
						$str= ' ';	
				
					echo '<option value="' . $rowC['Customer'] . '"   ' . $str . '> ' . $rowC['Customer']  . '  </option>';
				}
			}
		?>
	</select>
	
	<br />
	<p>
		If customer is not in this list, please ADD a new Customer<br />
		<a href="updateCustomer.php">ADD CUSTOMER</a>
		<!--form action="updateCustomer.php" method="post">
			<input type="submit" value="ADD CUSTOMER">
		</form-->
	</p>
	
	
	<!--input type="submit" name="loadOrders" value="LOAD ORDERS"/-->
	
	<input type="submit" name="addOrders" value="ADD ORDERS"/>
    
	<div id="showOrders">
		
		<h4>Current Orders <?php if (isset($custID)) echo ' of ' . $custID;  ?></h4>
		<?php
			if (isset($custID)) {
				
				$qOInfo = "SELECT *
						  FROM Orders
						  WHERE customerID='$custID';" ;
		
				$resultO = $conn->query($qOInfo);	
		
		
				if ($resultO->num_rows > 0) {
					
					echo "<table border='1'>";
					
					//TABLE HEADINGS
					echo "<tr>";
						echo "<th>Order ID</th>";
						echo "<th>Date</th>";
					echo "</tr>";
					
						// output data of each row
					while($rowO = $resultO ->fetch_assoc()) {
						
						//$orderID= $rowO['orderID'];
						$orderDate = $rowO['dateOfOrder'];
						
						echo "<tr>";
						
							echo"<td>" . $rowO['orderID'] . "</td>";
							echo "<td>" .$orderDate. "</td>";
	
							
						echo "</tr>";
						
					}
	
					
					echo "</table>";
				}	
				
			}
		?>

	</div>
	

</form>
	<div id="newOrder">
		
		
		
		<?php
			if (isset($custID) && isset($oID))
			{

				echo '<h4>Create new order</h4>';
				echo "<br / >NEW ORDER:" . $oID;
				
				echo "<br />";
				
				echo "<form method='post' action='addOrderDetail.php'>
					<input type='hidden' value='" . $custID  . "' name='custID' / >
					<input type='hidden' value='" . $oID  . "' name='orderID' / >
					<input type='hidden' value='ADD' name='task' />
					<input type='submit' value='ADD NEW ORDER' name='addOrder' />
					</form>
					";		
				
			}
			else{
				echo "<br/>Please select a customer!";
			}
		
		?>
		
		
		
		
	</div>

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
	<!--h2>Operations completed successfully!</h2-->
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