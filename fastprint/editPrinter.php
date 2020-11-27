<?php include("model/connection.php");
$title = 'หน้าใช้งาน';

include('model/header.php');
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["rank"] < 7){
    header("location: login.php");
    exit;
} 
include('model/data.php');

if(isset($_POST['sid']) && isset($_POST['sname']) && isset($_POST['slatitude']) && isset($_POST['slongtitude']) && isset($_POST['smaintenance'])) {

    if(strlen($_POST['sname']) == 0) {
        header('location: editPrinter.php?id='.$Id.'&name='.$Name.'&latitude='.$Latitude.'&longtitude='.$Longitude.'&maintenance='.$Maintenance.'&Update_Fail=ชื่อที่จะแก้ไขต้องไม่ว่าง');
        exit;
    }

    if(strlen($_POST['slatitude']) == 0) {
        header('location: editPrinter.php?id='.$Id.'&name='.$Name.'&latitude='.$Latitude.'&longtitude='.$Longitude.'&maintenance='.$Maintenance.'&Update_Fail=latitude ต้องไม่ว่าง');
        exit;
    }
    if(strlen($_POST['slongtitude']) == 0) {
        header('location: editPrinter.php?id='.$Id.'&name='.$Name.'&latitude='.$Latitude.'&longtitude='.$Longitude.'&maintenance='.$Maintenance.'&Update_Fail=longtitude ต้องไม่ว่าง');
        exit;
    }
    if($_POST['smaintenance'] < 0 && $_POST['smaintenance'] > 1) {
        header('location: editPrinter.php?id='.$Id.'&name='.$Name.'&latitude='.$Latitude.'&longtitude='.$Longitude.'&maintenance='.$Maintenance.'&Update_Fail=สถานะของ Maintenance ต้องเป็น 0 กับ 1 เท่านั้น');
        exit;
    }
    $Id = $_POST['sid'];
    $Name = $_POST['sname'];
    $Latitude = $_POST['slatitude'];
    $Longitude = $_POST['slongtitude'];
    $Maintenance = $_POST['smaintenance'];
    $strSQL = "UPDATE `printer_location` SET Name='".$Name."',latitude=".$Latitude.",longitude=".$Longitude.",maintenance=".$Maintenance." WHERE ID_Printer = ".$Id."" ;

    if (mysqli_query($conn, $strSQL)) {
		 
         header('location: Management.php?noti=แก้ไขเครื่องปริ้นเตอร์แล้ว');
         exit;
    } else {
         header('location: Management.php?error='.mysqli_error($conn));
         exit;
    }
    mysqli_close($conn);

    exit;
} else {
        if(!isset($_GET['id'])){
            header('location: Management.php?error=ไม่พบ id ที่ต้องการก้ไข');
            exit;
        }
        $id = $_GET['id'];
        $name = isset($_GET['Name'])?$_GET['Name']:'';
        $latitude = isset($_GET['latitude'])?$_GET['latitude']:'';
        $longitude = isset($_GET['longtitude'])?$_GET['longtitude']:'';
        $maintenance = isset($_GET['maintenance'])?$_GET['maintenance']:'';
}
?>
<div class = "Container">
  <div class="card col-sm-5 col-md-7 col-lg-5 mx-auto">
      <div class="card-title text-center">
      <br>
              <h1>แก้ไขเครื่องปริ้น</h1>
      </div>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
       
                    <div class="form-group">
                            
                        <label>ID</label>
                        <input type="text" name="sid" class="form-control" value='<?php echo $id;?>' placeholder="ID" readonly required>
                                  
                    </div>
                    <div class="form-group">
                            
                        <label>ชื่อสถานที่</label>
                        <input type="text" name="sname" class="form-control" value='<?php echo $name;?>' placeholder="ชื่อสถานที่" required>
                                  
                    </div>
                    <div class="form-group">
                        <label>ละติจูด </label>
                        <input type="text" name="slatitude" class="form-control" value='<?php echo $latitude;?>' placeholder="latitude" required>
                                    
                      </div>
                      <div class="form-group">
                        <label>ลองจิจูด </label>
                        <input type="text" name="slongtitude" class="form-control" value='<?php echo $latitude;?>' placeholder="longtitude" required>
                                    
                      </div>
                      <div class="form-group">
                        <label>บำรุงรักษา</label><small class="text-muted"> ตัวอย่าง: 0 = ปิด และ 1 = เปิด.</small>
                        <input type="text" name="smaintenance" class="form-control" value='<?php echo $maintenance;?>' placeholder="maintenance" required>
                      </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update">
                        <?php
                          if(isset($_GET['Update_Fail']) && strlen($_GET['Update_Fail']) > 0)
                            echo '<small class="text-danger" role="alert">'.$_GET["Update_Fail"].'</small>';
                          if(isset($_GET['updated'])) {
                            echo '<small class="text-success">อัพเดตข้อมูลแล้ว</small>';
                          }
                       ?>
                    </div>
                    
                </form>
    </div>
  </div>
      </div>
</div>
<br>
<?php
include('model/footer.php');
?>