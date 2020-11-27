<?php include("model/connection.php");
$title = 'Updating Profile';
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} 
include('model/data.php');
?>
<?php
	
	if(!isset($_POST['file']) || strlen($_POST['file']) == 0){
		header('location: Print.php?error=กรุณาอัพโหลดไฟล์เอกสาร หรือรูปภาพ');
		exit;
	}
	if(!isset($_POST['payment']) || strlen($_POST['payment']) == 0){
		header('location: Print.php?error=โปรดเลือกช่องทางการชำระเงิน');
		exit;
	}
	$file = $_POST["file"];
	$loc = $_POST["location"];
    $locID = explode(']',substr($loc,1,strlen($loc)))[0];
    $colorID = $_POST["colors"];
	$pages = $_POST["pages"];
	$payment = $_POST["payment"];
	
	
	//Check Printer
	$sql = 'SELECT ID_Printer FROM printer_location WHERE ID_Printer = '.$locID.' and printer_location.maintenance = 0;' or die("Error:" . mysqli_error());
    $locs = $conn->query($sql);

	if($locs->num_rows == 0) {
		header('location: Print.php?error=ไม่พบเครื่องปริ้น หรือกำลังปรับปรุงแก้ไขอยู่');
		exit;
	}
	
	$price = mysqli_fetch_array($conn->query('SELECT price FROM color WHERE Color_ID = '.$colorID))[0];
	$price *= $pages;
	
	//Check enough point
	if($point < $price){
		$requre = $price-$point;
		header('location: Print.php?error=ยอดเงินไม่เพียงพอ ต้องการอีก '.$requre.' ฿');
		exit;
	}
	$insertDataSQL = '
	INSERT INTO data (File) VALUES ("'.$file.'");
	SET @lastID = (SELECT LAST_INSERT_ID());
	INSERT INTO print (Color_ID, Status_ID, ID_Data, ID, ID_Printer, price) VALUES ('.$colorID.', 0, @lastID, '.$_SESSION['id'].', '.$locID.', '.$price.');
	set @balance = (SELECT Point FROM user WHERE ID = '.$_SESSION['id'].');
	SET @now = @balance-'.$price.';
	UPDATE user SET Point = @now  WHERE ID = '.$_SESSION['id'].' AND Point IN (SELECT Point FROM user WHERE Point >= '.$price.' and id = '.$_SESSION['id'].');
	';

	if (mysqli_multi_query($conn, $insertDataSQL)) {
		header('location: dashboard.php');
	} else {
         header('location: Print.php?error=มีบ้างอย่างผิดพลาด');
		exit;
    }
	
?>
