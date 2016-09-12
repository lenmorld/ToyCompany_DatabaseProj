<?php

/*
 *
 *Produce a report on the top three selling products of the Company (in terms of
total value of sales) during the past 12 months. List (among other details) the
name of the item, number of orders placed, number of items sold. 
 *
 */

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication


?>
<HTML>
<HEAD>
  <TITLE>UMC 353-4 DEMO - Q2</TITLE>
  
  <style>
	body { font-family: "Arial", Sans-serif; color: limegreen; background-color: black; }
	.depTable { background-color: gray; margin-left: 100px;}
  </style>

</HEAD>


<body>
    

<!---- Objective 2 ----->

<div id="objective2">
<hr>
<form method="post" action="q2.php">
	
    <h5>*Objective 2</h5>
    <h4>Top 3 Selling Products for a Given Year </h4>

	
	<label for="year">Enter Year</label>
	<input type="number" id="year" name="year" />
	
	<input type="submit" name="Query2" value="Query2" />
</form>

<!----- put results of the search dept here ---->
<div id="">

<table border="1">
	<?php
		if (isset($_POST['Query2']) && isset($_POST['year'])) {		// if verified see_employee button clicked do stuff here

        $year = $_POST['year'];
        
        //echo $year;

		$cQuery2 = "SELECT Items.companyItemID AS ItemID, Items.name AS ItemName, COUNT(OrderDetail.companyItemID) AS OrderQty, SUM(OrderDetail.orderPrice) AS SumPrice
					FROM OrderDetail, Orders, Items
					WHERE Orders.dateOfOrder >= '$year-01-01'
					AND Orders.dateOfOrder <= '$year-12-31'
					AND Orders.orderID = OrderDetail.orderID
					AND Orders.customerID = OrderDetail.customerID	
					AND OrderDetail.companyItemID = Items.companyItemID
					GROUP BY OrderDetail.orderID, OrderDetail.customerID, OrderDetail.companyItemID
					ORDER BY OrderDetail.orderPrice DESC
					LIMIT 3;";

           // echo $cQuery2;

			$result = $conn->query($cQuery2);
			
			if ($result->num_rows > 0) {
                
                	//TABLE HEADINGS
					echo "<tr>";
						echo "<th>Item ID</th>";
						echo "<th>Item Name</th>";
						echo "<th>Number of Orders</th>";
						echo "<th>Total value</th>";
					echo "</tr>";
                
                
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$iID = $row['ItemID'];			
					$iName = $row['ItemName'];
					$iQty = $row['OrderQty'];
					$iSum = $row['SumPrice'];
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $iID . "</td>";
						echo "<td>" . $iName . "</td>";
						echo "<td>" . $iQty . "</td>";
						echo "<td>" . $iSum . "</td>";
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
