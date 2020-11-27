<?php include("model/connection.php");
$title = 'Updating Price';
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["rank"] < 7){
    header("location: login.php");
    exit;
} 

?>
<?php
	 $name = $_POST["Name"]; 
     $latitude = $_POST["latitude"];
     $longitude = $_POST["longitude"];	 
	 $strSQL = "INSERT INTO printer_location (Name,latitude,longitude) VALUES ('".$name."','".$latitude. "','" .$longitude."')";
	
	if (mysqli_query($conn, $strSQL)) {
         header('location: Management.php?inserted_printer');
		 exit;
    } else {
		 header('location: Management.php?inserted_printer_fail=mysqli_error($conn)');
		 exit;
    }
    mysqli_close($conn);
?>