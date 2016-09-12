<div id="manipulateOrders">
	
	
	<!--  4. search ORDERS ** ADD/EDIT/DELETE -->
	<div>
	<!----------- show all orders ---------->
	<form method="post" action="index.php">
		<input type="submit" value="SEE ALL ORDERS" name="see_all_orders" id="see_all_orders" />
	</form>

	<!---------- ADD A ORDERS  --------->
	<!-- could be placed here or another page -->
	<!-- for now put in another page for simpicity -->
	<div>
		<!--a href="addOrderss.php">Add Employee</a-->
		<!--button onclick="child_open2()">ADD Orders</button-->
		<!--a href="javascript:child_open()">Add Employee</a-->
		<form action="updateOrders.php">
			<input type="submit" value="ADD ORDERS">
		</form>
	</div>
	
	<!----------- search a order ---------->
	<form method="post" action="index.php">

			<h3>Search an Order</h3>
		
			<label>Search by:</label>
			<!--select name="searchOrderOption">
			  <option value="oID">Order ID</option>
			  <option value="cID">Customer ID</option>
			</select-->
			
			<label for="searchOrderID">Order ID</label>
			<input type="text" id="searchOrderID" name="searchOrderID" />
			
			<label for="searchCustID">Customer ID</label>
			<input type="text" id="searchCustID" name="searchCustID" />
			
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
						WHERE customerID='$searchCustID' ; ";

		}  //both given
		else if ( $searchOrderID != '' && $searchCustID != '') {

			$query = "SELECT *
						FROM Orders
						WHERE customerID='$searchCustID' AND orderID='$searchOrderID' ; ";
		
		}
		else
		{
			echo "<br/>Error, must search by CustomerID and OrderID, or CustomerID alone";
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
							
							echo "<td> <form method='post' action='updateOrders.php'>
									<input type='hidden' value='" . $oID  . "' name='oID' / >
									<input type='hidden' value='" . $cID  . "' name='cID' / >
									<input type='hidden' value='EDIT' name='task' />  
									<input type='submit' value='EDIT' />
									</form>
							</td>";
							
							//echo "<td><button>DELETE</button></td>";
							echo "<td> <form method='post' action='index.php'>
									<input type='hidden' value='" . $oID  . "' name='oID' / >
									<input type='hidden' value='" . $cID  . "' name='cID' / >
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



<hr>
<!--------------------------------->
