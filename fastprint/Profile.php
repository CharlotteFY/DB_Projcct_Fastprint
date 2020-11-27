<?php 
$title = 'หน้าProfile';

include('model/header.php');

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} 

include('model/data.php');
?>



<div class = "Container">
  <div class="card col-sm-5 col-md-7 col-lg-5 mx-auto">
      <div class="card-title text-center">
              <i class="fa fa-user-circle-o fa-align-center fa-5x" aria-hidden="true"></i>
              <h1>ข้อมูลส่วนตัว</h1>
      </div>
      <form method="post" action="UpdateProfile.php">
                    <div class="form-group">
                      <h4> Point: <?php echo $point; ?> ฿</h4>
                    </div>

                     <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control" value='<?php echo $_SESSION["email"];?>' disabled>
                          
                    </div>
                    
                    <div class="form-group">
                            
                        <label>ชื่อ </label>
                        <input type="text" name="firstname" class="form-control" value='<?php echo $_SESSION["firstname"];?>' placeholder="ชื่อ" required>
                                  
                    </div>
                    <div class="form-group">
                        <label>นามสกุล </label>
                        <input type="text" name="lastname" class="form-control" value='<?php echo $_SESSION["lastname"];?>' placeholder="นามสกุล" required>
                                    
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