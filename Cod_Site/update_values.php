<?php

include("database_connect.php");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$value = $_POST['value'];		//Retinem valoarea
$unit = $_POST['unit'];			//Retinem id-ul
$column = $_POST['column'];		//Retinem coloana la care schimbam valoarea


mysqli_query($con,"UPDATE ESPtable2 SET $column = '{$value}'
WHERE id=$unit");

header("location: index.php");
?>