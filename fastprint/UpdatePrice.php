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
	
	foreach($_POST as $key => $value) {
		$strSQL = "UPDATE color SET price = '$value' where Color = '$key'" ;
			header('location: Management.php?update_paper_price_fail='.$strSQL.'');
			if (mysqli_query($conn, $strSQL)) {
				 header('location: Management.php?updated_paper_price');
			} else {
				 header('location: Management.php?update_paper_price_fail='.mysqli_error($conn));
			}
	}
	
    mysqli_close($conn);
	
?>
