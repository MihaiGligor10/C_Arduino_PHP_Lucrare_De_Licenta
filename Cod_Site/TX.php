<?php

include("database_connect.php"); 	

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


if (isset($_POST['value1'])) {
   
    $value1 = $_POST['value1'];
    mysqli_query($con, "UPDATE ESPtable2 SET SENT_NUMBER_1 = '$value1' WHERE id = 99999 AND PASSWORD = '12345'");
}

if (isset($_POST['value2'])) {
   
    $value2 = $_POST['value2'];
    mysqli_query($con, "UPDATE ESPtable2 SET SENT_NUMBER_2 = '$value2' WHERE id = 99999 AND PASSWORD = '12345'");
}

if (isset($_POST['value3'])) {
   
    $value3 = $_POST['value3'];
    mysqli_query($con, "UPDATE ESPtable2 SET SENT_NUMBER_3 = '$value3' WHERE id = 99999 AND PASSWORD = '12345'");
}

/////////////
$result = mysqli_query($con,"SELECT * FROM ESPtable2");	

while($row = mysqli_fetch_array($result)) {

		$b1 = $row['RECEIVED_BOOL1'];	
		$b2 = $row['RECEIVED_BOOL2'];
		$b3	= $row['RECEIVED_BOOL3'];
		$b4	= $row['RECEIVED_BOOL4'];
		$b5	= $row['RECEIVED_BOOL5'];
		$b6	= $row['RECEIVED_BOOL6'];
		$b_usa = $row['RECEIVED_BOOL_USA'];
		$b_garaj = $row['RECEIVED_BOOL_GARAJ'];
		$b_geam1 = $row['RECEIVED_BOOL_GEAM1'];
		$b_geam2 = $row['RECEIVED_BOOL_GEAM2'];

		$b_smoke = $row['RECEIVED_BOOL_SMOKE'];

		$n1 = $row['RECEIVED_NUM1'];	
		$n2 = $row['RECEIVED_NUM2'];
		$n3 = $row['RECEIVED_NUM3'];	
		$n6 = $row['TEXT_1'];
		
		
		echo "##$b1##$b2##$b3##$b4##$b5##$b6##$b_usa##$b_garaj##$b_geam1##$b_geam2##$b_smoke##$n1##$n2##$n3##$n6~";
	
}
?>








