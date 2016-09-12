<?php

/*
 *
Produce a report on the best three customers of the Company (in terms of total
value of purchases by the customer) during the past 12 months. List details on the
customers as well as the types, the number and value of their orders. 
 *
 */

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication


//print_r($_POST);

 if (isset($_POST['Query4']) && ( empty($_POST['year'])  )    )   {
            echo "<br/>Please enter year";
}

?>
<HTML>
<HEAD>
  <TITLE>UMC 353-4 DEMO - Q4</TITLE>
  
  <style>
	body { font-family: "Arial", Sans-serif; color: limegreen; background-color: black; }
	.depTable { background-color: gray; margin-left: 100px;}
  </style>

</HEAD>


<body>
    
<!---- Objective 4 ----->

<div id="objective4">

<hr>
<form method="post" action="q4.php">
	
    <h5>*Objective 4</h5>
    <h4>Best 3 Customers of the Company</h4>

	
	<label for="year">Year</label>
	<input type="number" id="year" name="year" />
    
	
	<input type="submit" name="Query4" value="Query4" />
</form>

<!----- put results of the search dept here ---->
<div id="">

<table border="1">
	<?php
		if (isset($_POST['Query4']) && isset($_POST['year'])  ) {		

        $year = $_POST['year'];
        

		$cQuery4 = "SELECT Customers.customerID AS CustomerID, Customers.cName AS CustomerName, Customers.cAddress AS CustomerAddress, Customers.cTelephone AS CustomerTel, COUNT(OrderDetail.customerID) AS Number_Orders, SUM(OrderDetail.orderPrice) AS Total_Value
					FROM Customers, OrderDetail, Orders
					WHERE Orders.dateOfOrder >= '$year-01-01'
					AND Orders.dateOfOrder <= '$year-12-31'
					AND Orders.orderID = OrderDetail.orderID
					AND Orders.customerID = OrderDetail.customerID
					AND OrderDetail.customerID = Customers.customerID
					GROUP BY OrderDetail.customerID
					ORDER BY TOTAL_VALUE DESC
					LIMIT 3;";

            echo $cQuery4;

			$result = $conn->query($cQuery4);
			
			if ($result->num_rows > 0) {
                
                	//TABLE HEADINGS
					echo "<tr>";
						echo "<th>Customer ID</th>";
						echo "<th>Customer Name</th>";
						echo "<th>Customer Address</th>";
						echo "<th>Customer Telephone</th>";
						echo "<th>Number of Orders</th>";
						echo "<th>Total Value</th>";
					echo "</tr>";
                
                
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$cID = $row['CustomerID'];			
					$cName = $row['CustomerName'];
					$cAddress = $row['CustomerAddress'];
					$cTel = $row['CustomerTel'];
					$cNumOrders = $row['Number_Orders'];
					$cValue = $row['Total_Value'];
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $cID . "</td>";
						echo "<td>" . $cName . "</td>";
						echo "<td>" . $cAddress . "</td>";
						echo "<td>" . $cTel . "</td>";
						echo "<td>" . $cNumOrders . "</td>";
						echo "<td>" . $cValue . "</td>";
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
