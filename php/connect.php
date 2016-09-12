<?php

//include('connect.php');

//$sql = "CREATE TABLE Persons ( FirstName varchar(15), LastName varchar(15), Age int )";
//mysql_query($sql,$con);


//mysql_query("INSERT INTO Persons (FirstName, LastName, Age) VALUES ('Peter', 'Griffin', '35')");
//mysql_query("INSERT INTO Persons (FirstName, LastName, Age) VALUES ('Glenn', 'Quagmire', '33')");

$server_name = 'umc353_4.encs.concordia.ca';
$user = 'umc353_4';
$pass = 'c353dkls';

$database = 'umc353_4';

// Create connection
$conn = new mysqli($server_name, $user, $pass, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


?>