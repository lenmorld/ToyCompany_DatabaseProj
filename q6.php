<?php

/*
 *
Prepare an invoice for customers who put an order(s). The invoice should include
all necessary information, e.g., date/time, customer, address, orders, payments,
signed by, etc. 

 *
 */

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication


//print_r($_POST);

?>
<HTML>
<HEAD>
  <TITLE>UMC 353-4 DEMO - Q5</TITLE>
  
  <style>
	body { font-family: "Arial", Sans-serif; color: limegreen; background-color: black; }
	.depTable { background-color: gray; margin-left: 100px;}
  </style>

</HEAD>


<body>
    
<!---- Objective 6 ----->

<div id="objective6">

<hr>
<form method="post" action="q6.php">
	
    <h5>*Objective 6</h5>
    <h4>Prepare an invoice</h4>

	
	<input type="submit" name="Query6" value="Query6" />
</form>

<!----- put results of the search dept here ---->
<div id="">

<table border="1">
	<?php
		if (isset($_POST['Query6'])   ) {		

		//$cQuery6 = "SELECT orderID, customerID, companyItemID, oQuantity, Round(orderPrice/oQuantity, 2) as UnitPrice, orderPrice
		//			FROM OrderDetail GROUP BY customerID, orderID;";
         
         
        $cQuery6 = "SELECT B.cName, B.cAddress, A.orderID, A.customerID, A.companyItemID, A.oQuantity, A.UnitPrice, A.orderPrice
            FROM Customers AS B,
            (SELECT orderID, customerID, companyItemID, oQuantity, Round(orderPrice/oQuantity, 2) as UnitPrice, orderPrice
            FROM OrderDetail GROUP BY customerID, orderID) AS A
            WHERE A.customerID = B.customerID
            ;";
            
                    
           // echo $cQuery6;

			$result = $conn->query($cQuery6);
			
			if ($result->num_rows > 0) {
                
                	//TABLE HEADINGS
					echo "<tr>";
						echo "<th>Order ID</th>";
						echo "<th>Customer ID</th>";
                        echo "<th>Customer Name</th>";
                        echo "<th>Customer Address</th>";
						echo "<th>Item ID</th>";
						echo "<th>Order Quantity</th>";
						echo "<th>Unit Price</th>";
						echo "<th>Total Order Price</th>";
					echo "</tr>";
                
                
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$oID = $row['orderID'];		
					$cID = $row['customerID'];
                    $cName = $row['cName'];
                    $cAddress = $row['cAddress'];
					$iID = $row['companyItemID'];
					$oQty = $row['oQuantity'];
					$iUnitPrice = $row['UnitPrice'];
					$oPrice = $row['orderPrice'];
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $oID . "</td>";
						echo "<td>" . $cID . "</td>";
                        echo "<td>" . $cName . "</td>";
                        echo "<td>" . $cAddress . "</td>";
						echo "<td>" . $iID . "</td>";
						echo "<td>" . $oQty . "</td>";
						echo "<td>" . $iUnitPrice . "</td>";
						echo "<td>" . $oPrice . "</td>";
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
