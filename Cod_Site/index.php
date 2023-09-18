<?php
//incepem o sesiune si verificam daca clientul e logat
session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    //daca clientul nu e logat il redirectionam la pagina de login
    header("Location: login.php");
    exit;
}
?>

<?php

//auto refresh la 20 de secunde pentru update la valorile primite de la senzori 
$page = $_SERVER['PHP_SELF'];
$sec = "20";
?>


<html>
<head>
<!--refresh-->
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">		
</head>
	
	
	
	
	
<body>    





<?php
include("database_connect.php"); 

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM ESPtable2");

echo "<style>
table {
  border-collapse: collapse;
  width: 100%;
  font-size: 18px;
}
th {
  padding: 10px;
  text-align: center;
  background-color: #80ff80;
}
td {
  padding: 10px;
  text-align: center;
}
tr:nth-child(even) {
  background-color: #a9c4e1;
}
td button {
  padding: 8px 16px;
  font-size: 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 100%;
}
.locked {
  background-color: #6ed829;
  color: white;
}
.unlocked {
  background-color: #e04141;
  color: white;
}
</style>";
  
echo "<table style='font-size: 30px;'>
	<thead>
		<tr>
		<th class='section-title'>Security</th>	
		</tr>
	</thead>
	
    <tbody>
      <tr >
        <td>Front door</td>
        <td>Garage</td>
		<td>Window 1</td>
        <td>Window 2</td>	
      </tr>  
		";
		  

while($row = mysqli_fetch_array($result)) {
	
   echo "<tr>"; 	
    $unit_id = $row['id'];
	
    $coloana7 = "RECEIVED_BOOL_USA";
    $coloana8 = "RECEIVED_BOOL_GARAJ";
	$coloana9 = "RECEIVED_BOOL_GEAM1";
    $coloana10 = "RECEIVED_BOOL_GEAM2";
	
   
	
    $val_curenta_7 = $row['RECEIVED_BOOL_USA'];
	$val_curenta_8 = $row['RECEIVED_BOOL_GARAJ'];
	$val_curenta_9 = $row['RECEIVED_BOOL_GEAM1'];
	$val_curenta_10 = $row['RECEIVED_BOOL_GEAM2'];
	
	

	if($val_curenta_7 == 1){
		$invers_val_curenta_7 = 0;
		$text_curent_7 = "Locked";
		$culoare_curenta_7 = "#6ed829";
	}
	else{
		$invers_val_curenta_7 = 1;
		$text_curent_7 = "Unlocked";
		$culoare_curenta_7 = "#e04141";
	}
	
	//////////////////////////////////////
	if($val_curenta_8 == 1){
		$invers_val_curenta_8 = 0;
		$text_curent_8 = "Closed";
		$culoare_curenta_8 = "#6ed829";
	}
	else{
		$invers_val_curenta_8 = 1;
		$text_curent_8 = "Open";
		$culoare_curenta_8 = "#e04141";
	}
	
	//////////////////////////////////////
	if($val_curenta_9 == 1){
		$invers_val_curenta_9 = 0;
		$text_curent_9 = "Closed";
		$culoare_curenta_9 = "#6ed829";
	}
	else{
		$invers_val_curenta_9 = 1;
		$text_curent_9 = "Open";
		$culoare_curenta_9 = "#e04141";
	}

	//////////////////////////////////////
	if($val_curenta_10 == 1){
		$invers_val_curenta_10 = 0;
		$text_curent_10 = "Closed";
		$culoare_curenta_10 = "#6ed829";
	}
	else{
		$invers_val_curenta_10 = 1;
		$text_curent_10 = "Open";
		$culoare_curenta_10 = "#e04141";
	}
	
	
	
	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_7  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana7 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 5%; font-size: 30px; text-align:center; background-color: $culoare_curenta_7' value=$text_curent_7></form></td>";
	
     
	
	echo "<td><form action= update_values.php method= 'post'>	
	<input type='hidden' name='value' value=$invers_val_curenta_8  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana8 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 10%; font-size: 30px; text-align:center; background-color: $culoare_curenta_8' value=$text_curent_8></form></td>";

	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_9  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana9 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 10%; font-size: 30px; text-align:center; background-color: $culoare_curenta_9' value=$text_curent_9></form></td>";

	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_10  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana10 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 10%; font-size: 30px; text-align:center; background-color: $culoare_curenta_10' value=$text_curent_10></form></td>";
	
	
	echo "</tr>
	  </tbody>"; 
	
}
echo "</table>
<br>
";	

?>







<?php
include("database_connect.php"); 

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM ESPtable2");


		  

echo "<table style='font-size: 30px;'>
	
	
    <tbody>
      <tr >
        <td>Front door alarm</td>
		<td>Smoke detector</td>
        
      </tr>  
		";
		  

while($row = mysqli_fetch_array($result)) {
	
   echo "<tr>"; 	
    $unit_id = $row['id'];
   
	
    $boolUS = "RECEIVED_BOOL6";

   
	
    $val_curenta_US = $row['RECEIVED_BOOL6'];

	

	if($val_curenta_US == 1){
		$invers_val_curenta_US = 0;
		$text_curent_US = "ON";
		$culoare_curenta_US = "#6ed829";
	}
	else{
		$invers_val_curenta_US = 1;
		$text_curent_US = "OFF";
		$culoare_curenta_US = "#e04141";
	}
	

	$boolSmoke = "RECEIVED_BOOL_SMOKE";

   
	
    $val_curentaSmoke = $row['RECEIVED_BOOL_SMOKE'];

	

	if($val_curentaSmoke == 1){
		$invers_val_curentaSmoke = 0;
		$text_curentSmoke = "ON";
		$culoare_curentaSmoke = "#6ed829";
	}
	else{
		$invers_val_curentaSmoke = 1;
		$text_curentSmoke = "OFF";
		$culoare_curentaSmoke = "#e04141";
	}

	
	
	
	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_US  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$boolUS >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 5%; font-size: 30px; text-align:center; background-color: $culoare_curenta_US' value=$text_curent_US></form></td>";
	
	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curentaSmoke  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$boolSmoke >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 5%; font-size: 30px; text-align:center; background-color: $culoare_curentaSmoke' value=$text_curentSmoke></form></td>";
	
	
	
	
	echo "</tr>
	  </tbody>"; 
	
}
echo "</table>
<br>
";

?>



<?php

include("database_connect.php");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM ESPtable2");

	
echo "<table  style='font-size: 30px;'>

	
    <tbody>
      <tr>
        <td>Proximity </td>
      </tr>  
		";
		  

while($row = mysqli_fetch_array($result)) {

 	echo "<tr>";   
	echo "<td>" . $row['SENT_NUMBER_2'] . "</td>";
	echo "</tr>
	</tbody>"; 

	
}
echo "</table>
<br>
";
?>


<?php

include("database_connect.php");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM ESPtable2");

	
echo "<table  style='font-size: 30px;'>

	
    <tbody>
      <tr >
        <td>Smoke</td>
      </tr>  
		";
		  

while($row = mysqli_fetch_array($result)) {

 	echo "<tr>";   
	echo "<td>" . $row['SENT_NUMBER_3'] . "</td>";
	echo "</tr>
	</tbody>"; 

	
}
echo "</table>
<br>
";
?>





<?php
include("database_connect.php"); 

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM ESPtable2");


echo "<table  style='font-size: 30px;'>
	<thead>
		<tr>
		<th>Lights</th>	
		</tr>
	</thead>
	
    <tbody>
      <tr >
        <td>Bedroom 1</td>
        <td>Bedroom 2</td>
		<td>Living   </td>
        <td>Bathroom </td>	
		<td>Kitchen  </td>	
      </tr>  
		";
		  
while($row = mysqli_fetch_array($result)) {
	
   echo "<tr>"; 	
    $unit_id = $row['id'];
	
    $coloana1 = "RECEIVED_BOOL1";
    $coloana2 = "RECEIVED_BOOL2";
	$coloana3 = "RECEIVED_BOOL3";
    $coloana4 = "RECEIVED_BOOL4";
	$coloana5 = "RECEIVED_BOOL5";
   
	
    $val_curenta_1 = $row['RECEIVED_BOOL1'];
	$val_curenta_2 = $row['RECEIVED_BOOL2'];
	$val_curenta_3 = $row['RECEIVED_BOOL3'];
	$val_curenta_4 = $row['RECEIVED_BOOL4'];
	$val_curenta_5 = $row['RECEIVED_BOOL5'];
	

	if($val_curenta_1 == 1){
		$invers_val_curenta_1 = 0;
		$text_curent_1 = "ON";
		$culoare_curenta_1 = "#6ed829";
	}
	else{
		$invers_val_curenta_1 = 1;
		$text_curent_1 = "OFF";
		$culoare_curenta_1 = "#e04141";
	}
	
	//////////////////////////////////////
	if($val_curenta_2 == 1){
		$invers_val_curenta_2 = 0;
		$text_curent_2 = "ON";
		$culoare_curenta_2 = "#6ed829";
	}
	else{
		$invers_val_curenta_2 = 1;
		$text_curent_2 = "OFF";
		$culoare_curenta_2 = "#e04141";
	}
	
	//////////////////////////////////////
	if($val_curenta_3 == 1){
		$invers_val_curenta_3 = 0;
		$text_curent_3 = "ON";
		$culoare_curenta_3 = "#6ed829";
	}
	else{
		$invers_val_curenta_3 = 1;
		$text_curent_3 = "OFF";
		$culoare_curenta_3 = "#e04141";
	}

	//////////////////////////////////////
	if($val_curenta_4 == 1){
		$invers_val_curenta_4 = 0;
		$text_curent_4 = "ON";
		$culoare_curenta_4 = "#6ed829";
	}
	else{
		$invers_val_curenta_4 = 1;
		$text_curent_4 = "OFF";
		$culoare_curenta_4 = "#e04141";
	}

	//////////////////////////////////////
	if($val_curenta_5 == 1){
		$invers_val_curenta_5 = 0;
		$text_curent_5 = "ON";
		$culoare_curenta_5 = "#6ed829";
	}
	else{
		$invers_val_curenta_5 = 1;
		$text_curent_5 = "OFF";
		$culoare_curenta_5 = "#e04141";
	}
	
	
	
	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_1  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana1 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 5%; font-size: 30px; text-align:center; background-color: $culoare_curenta_1' value=$text_curent_1></form></td>";
	
     
	
	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_2  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana2 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 10%; font-size: 30px; text-align:center; background-color: $culoare_curenta_2' value=$text_curent_2></form></td>";

	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_3  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana3 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 15%; font-size: 30px; text-align:center; background-color: $culoare_curenta_3' value=$text_curent_3></form></td>";

	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_4  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana4 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 10%; font-size: 30px; text-align:center; background-color: $culoare_curenta_4' value=$text_curent_4></form></td>";

	echo "<td><form action= update_values.php method= 'post'>
	<input type='hidden' name='value' value=$invers_val_curenta_5  size='15' >	
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana5 >
  	<input type= 'submit' name= 'change_but' style=' margin-left: 5%; margin-top: 10%; font-size: 30px; text-align:center; background-color: $culoare_curenta_5' value=$text_curent_5></form></td>";
	
	
	echo "</tr>
	  </tbody>"; 
	
}
echo "</table>
<br>
";	
?>
		
		
		


		
<?php
include("database_connect.php");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT * FROM ESPtable2");

echo "<table style='font-size: 30px;'>
	<thead>
		<tr>
		<th>Numeric controls</th>	
		</tr>
	</thead>
	
    <tbody>
      <tr>
        <td>Set max CO2 level</td>
      </tr>  
		";
		  
while($row = mysqli_fetch_array($result)) {

 	echo "<tr>";
   	
 
    $coloana7 = "RECEIVED_NUM2";
  
	$numar_curent2 = $row['RECEIVED_NUM2'];
	
  	echo "<td><form action= update_values.php method= 'post'>
  	<input type='text' name='value' style='width: 120px;' value=$numar_curent2  size='15' >
  	<input type='hidden' name='unit' style='width: 120px;' value=$unit_id >
  	<input type='hidden' name='column' style='width: 120px;' value=$coloana7 >
  	<input type= 'submit' name= 'change_but' style='text-align:center' value='change'></form></td>";
	
	
	echo "</tr>
	  </tbody>"; 
	
}
echo "</table>
<br>
";		
?>
		

	
	
		






<?php

include("database_connect.php");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT * FROM ESPtable2");


		
   echo "<table style='font-size: 30px;'>
	<thead>
		<tr>
		<th>Send a mesage home </th>	
		</tr>
	</thead>
	
    <tbody>
      <tr>
        <td>MAX 35 characters</td>        
      </tr>  
		";

while($row = mysqli_fetch_array($result)) {

 	 echo "<tr>";	
	
    $coloana11 = "TEXT_1"; 
    $text_curent_1 = $row['TEXT_1'];
	
		
	echo "<td><form action= update_values.php method= 'post'>
  	<input style='width: 100%;' type='text' name='value' value=$text_curent_1  size='100'>
  	<input type='hidden' name='unit' value=$unit_id >
  	<input type='hidden' name='column' value=$coloana11 >
  	<input type= 'submit' name= 'change_but' style='text-align:center' value='Send'></form></td>";
	
    echo "</tr>
	  </tbody>";      
	
}
echo "</table>
<br>
<br>
<hr>";
		
?>
				









<?php

include("database_connect.php");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM ESPtable2");

	
echo "<table style='font-size: 30px;'>
	<thead>
		<tr>
		<th>Senzori</th>	
		</tr>
	</thead>
	
    <tbody>
      <tr >
        <td>Temperatura</td>
      </tr>  
		";
		  

while($row = mysqli_fetch_array($result)) {

 	echo "<tr>";   
	echo "<td>" . $row['SENT_NUMBER_1'] . "</td>";
	echo "</tr>
	</tbody>"; 

	
}
echo "</table>
<br>
";


 

?> 

<form method="post" action="logout.php">
  <button type="submit" name="logout" style="font-size: 20px; padding: 15px 30px;">Logout</button>
</form>