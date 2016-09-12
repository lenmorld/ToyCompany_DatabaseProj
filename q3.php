<?php

/*
 *
 Given a month and year, list, in descending order, the average price of all items
ordered and/or are present in the inventory. 
 *
 */

include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication


//print_r($_POST);

 if (isset($_POST['Query3']) && ( empty($_POST['year']) ||  empty($_POST['month'])  )    )   {
            echo "<br/>Please enter year and month";
}

?>
<HTML>
<HEAD>
  <TITLE>UMC 353-4 DEMO - Q3</TITLE>
  
  <style>
	body { font-family: "Arial", Sans-serif; color: limegreen; background-color: black; }
	.depTable { background-color: gray; margin-left: 100px;}
  </style>

</HEAD>


<body>
    
<!---- Objective 3 ----->

<div id="objective3">

<hr>
<form method="post" action="q3.php">
	
    <h5>*Objective 3</h5>
    <h4>Average price of all items ordered and/or in inventory</h4>

	
	<label for="year">Year</label>
	<input type="number" id="year" name="year" />
    
    <label for="year">Month</label>
	<input type="number" id="month" name="month" />
	
	<input type="submit" name="Query3" value="Query3" />
</form>

<!----- put results of the search dept here ---->
<div id="">

<table border="1">
	<?php
		if (isset($_POST['Query3']) && isset($_POST['year']) &&  isset($_POST['month']) ) {		

        $year = $_POST['year'];
        $month = $_POST['month'];
        
        //echo $year;

		$cQuery3 = "SELECT Items.name AS ItemName, ROUND(AVG(InventoryHistoryPrice.unitPrice), 2) AS AVERAGE_VALUE
					FROM Items, InventoryHistoryPrice
					WHERE InventoryHistoryPrice._priceDate >= '$year-$month-01'
					AND InventoryHistoryPrice._priceDate <= '$year-$month-31'
					AND InventoryHistoryPrice.companyItemID = Items.companyItemID
					GROUP BY InventoryHistoryPrice.companyItemID
					ORDER BY AVERAGE_VALUE DESC;";

            //echo $cQuery3;

			$result = $conn->query($cQuery3);
			
			if ($result->num_rows > 0) {
                
                	//TABLE HEADINGS
					echo "<tr>";
						echo "<th>Item Name</th>";
						echo "<th>Average Unit Price</th>";
					echo "</tr>";
                
                
				// output data of each row
				while($row = $result->fetch_assoc()) {
				
					$iName = $row['ItemName'];			
					$iUnitPriceAvg = $row['AVERAGE_VALUE'];
					
					//each tuple
					echo "<tr>";
						echo "<td>" . $iName . "</td>";
						echo "<td>" . $iUnitPriceAvg . "</td>";
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
