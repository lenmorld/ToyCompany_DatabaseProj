<?php

/*
 *
Make a list of outstanding payments for products already shipped out to
customers.
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
    
<!---- Objective 5 ----->

<div id="objective5">

<hr>
<form method="post" action="q5.php">
	
    <h5>*Objective 5</h5>
    <h4>Outstanding payments for products</h4>

	
	<input type="submit" name="Query5" value="Query5" />
</form>

<!----- put results of the search dept here ---->
<div id="">

<table border="1">
	<?php
		if (isset($_POST['Query5'])   ) {		

       // $year = $_POST['year'];
        

		$cQuery5 = "SELECT A.orderID AS OrderID, A.customerID AS CustomerID, B.totalPrice AS TotalPrice, A.pricePerMonth AS PricePerMonth, A.numOfPays AS NumberPay, B.totalPrice - (A.pricePerMonth * A.numOfPays) AS OutstandingPayment
					FROM
					(SELECT t2.orderID, t2.customerID, t3.pricePerMonth, t2.numOfPays FROM (SELECT orderID, customerID, COUNT(*) as numOfPays FROM installmentPayment GROUP BY orderID, customerID) as t2
					INNER JOIN (SELECT orderID, customerID, pricePerMonth FROM Installment GROUP BY orderID, customerID) as t3
					ON(t2.orderID = t3.orderID AND t2.customerID = t3.customerID)) as A
					INNER JOIN (SELECT orderID, customerID, totalPrice FROM AccountPayments 
					WHERE EXISTS(SELECT orderID, customerID FROM Installment 
					WHERE(AccountPayments.orderID = orderID AND AccountPayments.customerID = customerID))) as B
					ON(A.orderID = B.orderID AND A.customerID = B.customerID);";

            //echo $cQuery5;

			$result = $conn->query($cQuery5);
			
			if ($result->num_rows > 0) {
                
                	//TABLE HEADINGS
					echo "<tr>";
						echo "<th>Customer ID</th>";
						echo "<th>Customer Name</th>";
						echo "<th>Customer Address</th>";
						echo "<th>Customer Telephone</th>";
						echo "<th>Number of Orders</th>";
						echo "<th>Missing Payment</th>";
					echo "</tr>";
                
                
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$oID = $row['OrderID'];		
					$cID = $row['CustomerID'];
					$oTotal = $row['TotalPrice'];
					$oPriceMonth = $row['PricePerMonth'];
					$oNumPay = $row['NumberPay'];
					$oOutPay = $row['OutstandingPayment'];
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $cID . "</td>";
						echo "<td>" . $oID . "</td>";
						echo "<td>" . $oTotal . "</td>";
						echo "<td>" . $oPriceMonth . "</td>";
						echo "<td>" . $oNumPay . "</td>";
						echo "<td>" . $oOutPay . "</td>";
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
