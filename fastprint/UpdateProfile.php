<?php include("model/connection.php");
$title = 'Updating Profile';
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} 

?>
<?php
	$emailPost = $_SESSION['email'];
    $firstnamePost = $_POST["firstname"];
    $lastnamePost = $_POST["lastname"];
	
	$strSQL = "UPDATE user SET Firstname = '$firstnamePost', Lastname = '$lastnamePost' WHERE E_Mail = '$emailPost';" ;
 if (mysqli_query($conn, $strSQL)) {
		 $_SESSION['firstname'] = $firstnamePost;
		 $_SESSION['lastname'] = $lastnamePost;
         header('location: Profile.php?updated');
    } else {
         header('location: Profile.php?Update_Fail='.mysqli_error($conn));
    }
    mysqli_close($conn);
	
?>
