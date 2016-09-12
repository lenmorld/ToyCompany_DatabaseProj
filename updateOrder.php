<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication



print_r($_POST);



if (isset($_POST['oID']) && isset($_POST['cID']))
{
    
        $orderID = $_POST['oID'];
        $custID= $_POST['cID'];
        $item = $_POST['item'];
        $qty = $_POST['qty'];
        
        //if EDIT is CLICKED
        if (isset($_POST['editQty']))
        {
             // $_POST['qty']
              
              //get updated item price
              
             $qPrice = "SELECT unitPrice
                        FROM Inventory
                        WHERE companyItemID='$item'
                        AND iQuantity > 0 ;
                        ";
                        
            echo $qPrice;
            
            $resultPrice = $conn->query($qPrice);	

			if ($resultPrice->num_rows > 0) {
			 
                    $rowP = $resultPrice->fetch_assoc();
                     $price = $rowP['unitPrice'];
   
                    //update the database
                     $qUpdateQty = "UPDATE OrderDetail
                                    SET oQuantity='$qty', orderPrice='" . ($qty * $price) .  "'
                                    WHERE orderID='$orderID'
                                    AND customerID='$custID'
                                    AND companyItemID='$item';";
                    
                    if ($conn->query($qUpdateQty) === TRUE) {
                        echo "<br/>Update successfully<br />";
                        
                    } else {
                     echo "<br/> Error: " .  $qUpdateQty . "<br>" . $conn->error;
                    }          
            }
            else
            {   echo "0 results";
            }
        }
        else  if (isset($_POST['delOrders']))         //DELETE is CLICKED
        {
            $qDelOrder = "DELETE FROM OrderDetail
                        WHERE orderID='$orderID'
                        AND customerID='$custID'
                        AND companyItemID='$item';";
                        
            if ($conn->query($qDelOrder) === TRUE) {
                echo "<br/>Delete successfully<br />";
                
            } else {
             echo "<br/> Error: " .  $qDelOrder. "<br>" . $conn->error;
            }                        
                
        }

}





?>


<html>

<head>
	<title>Add/Edit/Delete OrderDetail UMC-353-4</title>
	
	<link rel="stylesheet" href="css/add.css" type="text/css">

</head>

<body>
    
    
<div id="manipulateOrderDetails">
	
	
	<!--  4. search ORDERDETAILS ** ADD/EDIT/DELETE -->
	<div>
	<!----------- show all orders ---------->
	<!--form method="post" action="index.php">
		<input type="submit" value="SEE ALL ORDERS" name="see_all_orders" id="see_all_orders" />
	</form-->


	<?php

if (isset($_POST['oID']) && isset($_POST['cID']))
{
    
        
          $qOrderDetail = "SELECT *
                FROM OrderDetail
                WHERE orderID='$orderID' AND customerID='$custID';
                ";
                
            $result = $conn->query($qOrderDetail);
    

		//check if there is at least 1 result
		if ($result->num_rows > 0) {
            
		echo "<table border='1'>";
		
			//TABLE HEADINGS
			echo "<tr>";
				echo "<th>Order ID</th>";
				echo "<th>CustomerID</th>";
				echo "<th>CompanyItem ID</th>";
				echo "<th>Quantity</th>";
				echo "<th>Order Price</th>";
				echo "<th>" .  $dummy . "</th>"; 
				echo "<th>" .  $dummy . "</th>"; 
			echo "</tr>";
		
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$oID = $row['orderID'];
				$cID = $row['customerID'];
				
				//print_r( $row );
				//each tuple          
                
				echo "<tr><form method='post' action='updateOrder.php'>";
							//echo "<div style='border: 1px blue solid;'>";
					
							//echo "<td><input type='text' value='" . $cID . "' name='cID' disabled/></td>";
							echo"<td>" . $oID . "</td>";
							echo"<td>" . $cID . "</td>";
                            echo"<td>" . $row['companyItemID'] . "</td>";
                            echo"<td><input type='number' name='qty' value='" . $row['oQuantity'] . "'/></td>";
                            echo"<td>" . $row['orderPrice'] . "</td>";


							//echo "<td><button onclick='child_open()'>EDIT</button></td>";
							//echo "<td> <a href='javascript:child_open()'>EDIT</a>  </td>";
							
							echo "<td> 
									<input type='hidden' value='" . $oID  . "' name='oID' / >
									<input type='hidden' value='" . $cID  . "' name='cID' / >
                                    <input type='hidden' value='" . $row['companyItemID']  . "' name='item' / >
									<input type='hidden' value='EDIT' name='task' />  
									<input type='submit' value='EDIT' name='editQty' />
									
							</td>";
							
							//echo "<td><button>DELETE</button></td>";
							echo "<td> <!--form method='post' action='index.php'-->
									<input type='hidden' value='" . $oID  . "' name='oID' / >
									<input type='hidden' value='" . $cID  . "' name='cID' / >
                                    <input type='hidden' value='" . $row['companyItemID']   . "' name='item' / >
									<input type='submit' value='DELETE' name='delOrders' />
									<!--/form-->
							</td>";
					
					//echo "</div>";
					
					//echo "</div>";
				echo "</tr></form>";		// end of current order info
			}
			
		echo "</table>";			//end of order table	
		} else {
			 echo "no items in your cart";
		}	

		}
	?>
	
	<hr>

	 <!-- END OF 4.  ORDERS ------->	
	</div>
	
</div>



<hr>
    

<!--------- add employee form ------>

	<h3>Operations completed successfully!</h3>
	<h3><a href="index.php" />HOME</h3>
	<!--h3><a href="addOrder.php" />ADD ORDER</h3-->

<!--------------------------------->

<?php 
//close DB connection, only do it after all php-mysql stuff are done
//put it at the end
$conn->close();
?>
</body>


</html>