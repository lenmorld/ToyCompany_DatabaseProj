<?php
//------> ob_start();
include('./php/connect.php');	//mysql connection credentials
$authenticated = true;			//in case we implement authentication


//############# TESTING CODE ########
echo '<br/>####### Testing code ######<br/>';
print_r($_POST);
echo '<br/>############################<br/>';

if (isset($_POST['delDependent']))		// DELETE DEPENDENT handled in this page
{
	//DELETE dependent
	$dID = $_POST['dID'];
	
		$qDelete = "DELETE 
					FROM Dependents
				   WHERE dSIN='$dID' ;"  ;

		echo $qDelete;
		
		if ($conn->query($qDelete) === TRUE) {
			echo "Dependent deleted successfully";
			
            
			$successfulDelete = true;
			
            $eID = $_POST['eID'];
            
			//header('Location: ./index.php');
			//exit;
		} else {
			echo "Error: " . $qDelete . "<br>" . $conn->error;
		}
}

?>
<html>
    <head>
        
        
    </head>
    
    
    <body>
        
        <?php
            if (isset($successfulDelete))
                echo "
                	<h2>Operations completed successfully!</h2>
						<form method='post' action='updateEmployee.php'>
									<input type='hidden' value='" . $eID  . "' name='eID' / >
									<input type='hidden' value='EDIT' name='task' />  
									<input type='submit' value='GO BACK TO EMPLOYEE PAGE' />
						</form>     
                    ";
        ?>
        
    </body>
</html>

<?php

//---------->ob_end_flush();

?>