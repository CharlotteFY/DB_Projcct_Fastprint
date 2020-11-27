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

	 $idPost = $_GET["id"]; 
     $strSQL = "DELETE FROM `printer_location` WHERE ID_Printer = ".$idPost;
	
	if (mysqli_query($conn, $strSQL)) {
         header('location: Management.php?noti=ลบเครื่องปริ้นแล้ว');
		 exit;
    } else {
		 header('location: Management.php?error='.mysqli_error($conn).'');
		 exit;
    }
    mysqli_close($conn);
?>