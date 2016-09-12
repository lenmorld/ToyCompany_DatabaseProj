<?php

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication

//############# TESTING CODE ########
echo '<br/>####### Testing code ######<br/>';
print_r($_POST);
echo '<br/>############################<br/>';

//show items list

$custID = $_POST['custID'];
$orderID = $_POST['orderID'];



//add item  ##### ADD ITEM IS CLICKED ######
if (isset($_POST['addItem'])) {
    
    //check if no item selected or quantity is 0
    
    $itemT = $_POST['item'];
    $qty = $_POST['iQuantity'];
    
    
    	$temp = explode(":", $itemT);
		echo "<br/>" . $temp[0];
		
		$item = $temp[0];

   // if ($item == 'NONE' || $qty <=0)
     //   echo "<br/>Please select item and enter quantity";
    
        if ($item == 'NONE')
             echo "<br/>Please select item";
        else {
            
            //get price of item
            
            $qPrice = "SELECT unitPrice
                        FROM Inventory
                        WHERE companyItemID='$item'
                        AND iQuantity > 0 ;
                        ";
                        
            echo $qPrice;
            
            $resultPrice = $conn->query($qPrice);	

			if ($resultPrice->num_rows > 0) {
			 
                    $rowP = $resultPrice->fetch_assoc();
                    
                    $price = $rowP['unitPrice'] * $qty;
             
                     //insert to database    
        
                    $qInsert = "INSERT INTO OrderDetail
                            VALUES ('$orderID', '$custID', '$item', '$qty', '$price');";
             
                    if ($conn->query($qInsert) === TRUE) {
                        echo "<br/>Item inserted successfully<br />";

                        
                    } else {
                     echo "<br/> Error: " . $qInsert . "<br>" . $conn->error;
                    }
			}
            else
            {
                echo "<br/>Item not found or OUT OF STOCK";
            } 
        }
}
else if (isset($_POST['doneAdding'])) 
{
	//$doneAdding = true;
}
else        //page just loaded
{
    //put in Orders
    $date = date('Y-m-d');
    
    $qInsert = "INSERT INTO Orders
                Values ('$orderID', '$custID', '$date' );";
                
                    
    if ($conn->query($qInsert) === TRUE) {
        echo "<br/>Order inserted successfully<br />";
    } else {
        echo "<br/> Error: " . $qInsert . "<br>" . $conn->error;
    }   

}

?>


<html>


<head>
	<title>Add/Edit/Delete OrderDetails UMC-353-4</title>
	<link rel="stylesheet" href="css/add.css" type="text/css">
</head>

<body>
    
    <br/>  
    <br/>
    
    


    
<form method="post" action="addOrderDetail.php">

	<select name="item">
		<option value="NONE">Select Item</option>
		<?php
			//get all customers
	
			$qIInfo = "SELECT CONCAT(companyItemID, ':', name) AS item
					  FROM Items;";
	
			$resultIInfo = $conn->query($qIInfo);	
	
			if ($resultIInfo->num_rows > 0) {
				while($rowI = $resultIInfo ->fetch_assoc()) {

					echo '<option value="' . $rowI['item'] . '"> ' . $rowI['item']  . '  </option>';
				}
			}
		?>
	</select>
    
    <label for="iQuantity">Quantity</label>
    <input type="number" name="iQuantity" value=""/>
    
    <input type='hidden' value='<?php echo $orderID; ?>' name='orderID' / >
    <input type='hidden' value='<?php echo $custID; ?>' name='custID' / >

    <input type="submit" name="addItem" value="ADD ITEM"/>

</form>

<form method="post" action="addOrder.php">
	<input type='hidden' value='<?php echo $custID; ?>' name='customer' / >
	 <input type="submit" name="doneAdding" value="DONE ADDING"/>
</form>



<div>
    <?php
    
    
    if (isset($orderID) && isset($custID))
  
    {
              $qOrderDetail = "SELECT *
                    FROM OrderDetail
                    WHERE orderID='$orderID' AND customerID='$custID';
                    ";
                    
                $result = $conn->query($qOrderDetail);
        
                if ($result->num_rows > 0) {
					
					echo "<table border ='1'>";
					
					
					echo "<tr>";
						echo "<th>Order ID</th>";
						echo "<th>Customer ID</th>";
						echo "<th>Item</th>";
						echo "<th>Quantity</th>";
						echo "<th>Price</th>";
					echo "</tr>";			
				
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
						
						echo "<tr>";
					
                       echo "<td> " . $row['orderID'] . "</td>";
                       echo "<td> " . $row['customerID']   . "</td>";
                       echo "<td> " . $row['companyItemID']  . "</td>";
                       echo "<td> " . $row['oQuantity']   . "</td>";
                       echo "<td> " . $row['orderPrice']   . "</td>";
					   
					   echo "</tr>";
                
                        //echo "===========================<br/>";
                  }

				echo "</table>";
                }
                else {
                    echo "no items in your cart";
                }
    }
    
    ?>
    
    </div>
    
  
    
    
    
<!--------------------------------->

<?php 
//close DB connection, only do it after all php-mysql stuff are done
//put it at the end
//$conn->close();
?>
</body>


</html>