//----------------------------------------------------------------------------------------
//QUERIES #2

//Assuming we are using buttons to get the right queries
//Unique button for each query --> Must select a Year which we will input into $year
//We need to get the year

$year = 2016; //Using 2016 as an example, this value will taken from an input instead

if (isset($_POST['Query2']))
{
		$cQuery2 = "SELECT Items.companyItemID AS ItemID, Items.name AS ItemName, COUNT(OrderDetail.companyItemID) AS OrderQty, SUM(OrderDetail.orderPrice) AS SumPrice
					FROM OrderDetail, Orders, Items
					WHERE Orders.dateOfOrder >= ' . $year . '-01-01'
					AND Orders.dateOfOrder <= ' . $year . '-12-31'
					AND Orders.orderID = OrderDetail.orderID
					AND Orders.customerID = OrderDetail.customerID	
					AND OrderDetail.companyItemID = Items.companyItemID
					GROUP BY OrderDetail.orderID, OrderDetail.customerID, OrderDetail.companyItemID
					ORDER BY OrderDetail.orderPrice DESC
					LIMIT 3;";

		//echo $qEdit;
		
		$result = $conn->query($cQuery2);
		
		if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$iID = $row['ItemID'];			
					$iName = $row['ItemName'];
					$iQty = $row['OrderQty'];
					$iSum = $row['SumPrice'];
					
					echo "<tr>";
						echo "<th>Item ID</th>";
						echo "<th>Item Name</th>";
						echo "<th>Number of Orders</th>";
						echo "<th>Total value</th>";
					echo "</tr>";
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $iID . "</td>";
						echo "<td>" . $iName . "</td>";
						echo "<td>" . $iQty . "</td>";
						echo "<td>" . $iSum . "</td>";
					echo "</tr>";
				}
		}
		else{
			echo "<br>0 results";
		}				
}

//-----------------------------------------------------------------------------------

//QUERIES #3

$year = 2016; //Using 2016 as an example, this value will taken from an input instead
if (isset($_POST['Query3']))
{
		$cQuery3 = "SELECT Items.name AS ItemName, ROUND(AVG(InventoryHistoryPrice.unitPrice), 2) AS AVERAGE_VALUE
					FROM Items, InventoryHistoryPrice
					WHERE InventoryHistoryPrice._priceDate >= ' . $year . '-01-01'
					AND InventoryHistoryPrice._priceDate <= ' . $year . '-12-31'
					AND InventoryHistoryPrice.companyItemID = Items.companyItemID
					GROUP BY InventoryHistoryPrice.companyItemID
					BY AVERAGE_VALUE DESC;";

		//echo $qEdit;
		
		$result = $conn->query($cQuery3);
		
		if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$iName = $row['ItemName'];			
					$iUnitPriceAvg = $row['AVERAGE_VALUE'];
					
					echo "<tr>";
						echo "<th>Item Name</th>";
						echo "<th>Average Unit Price</th>";
					echo "</tr>";
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $iName . "</td>";
						echo "<td>" . $iUnitPriceAvg . "</td>";
					echo "</tr>";
				}
		}
		else{
			echo "<br>0 results";
		}				
}


//-----------------------------------------------------------------------------------

//QUERIES #4

$year = 2016; //Using 2016 as an example, this value will taken from an input instead

if (isset($_POST['Query4']))
{
		$cQuery4 = "SELECT Customers.customerID AS CustomerID, Customers.cName AS CustomerName, Customers.cAddress AS CustomerAddress, Customers.cTelephone AS CustomerTel, COUNT(OrderDetail.customerID) AS Number_Orders, SUM(OrderDetail.orderPrice) AS Total_Value
					FROM Customers, OrderDetail, Orders
					WHERE Orders.dateOfOrder >= ' . $year . '-01-01'
					AND Orders.dateOfOrder <= ' . $year . '-01-01'
					AND Orders.orderID = OrderDetail.orderID
					AND Orders.customerID = OrderDetail.customerID
					AND OrderDetail.customerID = Customers.customerID
					GROUP BY OrderDetail.customerID
					ORDER BY TOTAL_VALUE DESC
					LIMIT 3;";

		//echo $qEdit;
		
		$result = $conn->query($cQuery4);
		
		if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$cID = $row['CustomerID'];			
					$cName = $row['CustomerName'];
					$cAddress = $row['CustomerAddress'];
					$cTel = $row['CustomerTel'];
					$cNumOrders = $row['Number_Orders'];
					$cValue = $row['Total_Value'];
					
					echo "<tr>";
						echo "<th>Customer ID</th>";
						echo "<th>Customer Name</th>";
						echo "<th>Customer Address</th>";
						echo "<th>Customer Telephone</th>";
						echo "<th>Number of Orders</th>";
						echo "<th>Total Value</th>";
					echo "</tr>";
					
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
		}
		else{
			echo "<br>0 results";
		}				
}

//---------------------------------------------------------------------------------
//QUERY #5
if (isset($_POST['Query5']))
{
		$cQuery5 = "SELECT A.orderID AS OrderID, A.customerID AS CustomerID, B.totalPrice AS TotalPrice, A.pricePerMonth AS PricePerMonth, A.numOfPays AS NumberPay, B.totalPrice - (A.pricePerMonth * A.numOfPays) AS OutstandingPayment
					FROM
					(SELECT t2.orderID, t2.customerID, t3.pricePerMonth, t2.numOfPays FROM (SELECT orderID, customerID, COUNT(*) as numOfPays FROM installmentPayment GROUP BY orderID, customerID) as t2
					INNER JOIN (SELECT orderID, customerID, pricePerMonth FROM Installment GROUP BY orderID, customerID) as t3
					ON(t2.orderID = t3.orderID AND t2.customerID = t3.customerID)) as A
					INNER JOIN (SELECT orderID, customerID, totalPrice FROM AccountPayments 
					WHERE EXISTS(SELECT orderID, customerID FROM Installment 
					WHERE(AccountPayments.orderID = orderID AND AccountPayments.customerID = customerID))) as B
					ON(A.orderID = B.orderID AND A.customerID = B.customerID);";

		//echo $qEdit;
		
		$result = $conn->query($cQuery5);
		
		if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$oID = $row['OrderID'];		
					$cID = $row['CustomerID'];
					$oTotal = $row['TotalPrice'];
					$oPriceMonth = $row['PricePerMonth'];
					$oNumPay = $row['NumberPay'];
					$oOutPay = $row['OutstandingPayment'];
					
					echo "<tr>";
						echo "<th>Customer ID</th>";
						echo "<th>Customer Name</th>";
						echo "<th>Customer Address</th>";
						echo "<th>Customer Telephone</th>";
						echo "<th>Number of Orders</th>";
						echo "<th>Missing Payment</th>";
					echo "</tr>";
					
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
		}
		else{
			echo "<br>0 results";
		}				
}


//-----------------------------------------------------------------------------------
//QUERY #6
if (isset($_POST['Query6']))
{
		$cQuery6 = "SELECT orderID, customerID, companyItemID, oQuantity, Round(orderPrice/oQuantity, 2) as UnitPrice, orderPrice
					FROM OrderDetail GROUP BY customerID, orderID;";

		//echo $qEdit;
		
		$result = $conn->query($cQuery6);
		
		if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$oID = $row['orderID'];		
					$cID = $row['customerID'];
					$iID = $row['companyItemID'];
					$oQty = $row['oQuantity'];
					$iUnitPrice = $row['UnitPrice'];
					$oPrice = $row['orderPrice'];
					
					echo "<tr>";
						echo "<th>Order ID</th>";
						echo "<th>Customer ID</th>";
						echo "<th>Item ID</th>";
						echo "<th>Order Quantity</th>";
						echo "<th>Unit Price</th>";
						echo "<th>Total Order Price</th>";
					echo "</tr>";
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $oID . "</td>";
						echo "<td>" . $cID . "</td>";
						echo "<td>" . $iID . "</td>";
						echo "<td>" . $oQty . "</td>";
						echo "<td>" . $iUnitPrice . "</td>";
						echo "<td>" . $oPrice . "</td>";
					echo "</tr>";
				}
		}
		else{
			echo "<br>0 results";
		}				
}








