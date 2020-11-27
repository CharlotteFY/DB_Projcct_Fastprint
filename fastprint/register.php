<?php 
$title = 'สมัครสมาชิก';

include('model/header.php');

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]){
    header("location: dashboard.php");
    exit;
}

$firstname = $lastname = $email = $password = $confirm_password = "";
$firstname_err = $lastname_err = $email_err = $password_err = $confirm_password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 //Validate Firstname
 if(empty(trim($_POST["firstname"]))){
    $firstname_err = "โปรดใส่ชื่อของคุณ"; 
 } elseif(strlen(trim($_POST["password"])) == 0){
    $firstname_err = "โปรดระบุนามสกุลของคุณ";
} else {
     $firstname = $_POST['firstname'];
 }
 //Validate Lastname
 if(empty(trim($_POST["lastname"]))){
    $lastname_err = "โปรดใส่ชื่อของคุณ"; 
 } elseif(strlen(trim($_POST["password"])) == 0){
    $lastname_err = "โปรดระบุชื่อของคุณ";
 } else {
     $lastname = $_POST['lastname'];
 }
 // Validate email
 if(empty(trim($_POST["email"]))){
     $email_err = "กรุณาใส่อีเมลของคุณ";
 } else{
     // Prepare a select statement
     $sql = "SELECT id FROM user WHERE E_Mail = ?";
     
     if($stmt = mysqli_prepare($conn, $sql)){
         // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt, "s", $param_email);
         
         // Set parameters
         $param_email = trim($_POST["email"]);
         
         // Attempt to execute the prepared statement
         if(mysqli_stmt_execute($stmt)){
             /* store result */
             mysqli_stmt_store_result($stmt);
             
             if(mysqli_stmt_num_rows($stmt) == 1){
                 $email_err = "อีเมลนี้ ถูกใช้งานไปแล้ว";
             } else{
                 $email = trim($_POST["email"]);
             }
         } else{
             echo "มีบ้างอย่างผิดพลาด โปรดทำรายการใหม่อีกครั้ง";
         }

         // Close statement
         mysqli_stmt_close($stmt);
     }
 }
 
 // Validate password
 if(empty(trim($_POST["password"]))){
     $password_err = "โปรดใส่ รหัสผ่าน";     
 } elseif(strlen(trim($_POST["password"])) < 6){
     $password_err = "ความยาวรหัสผ่านต้องไม่น้อยกว่า 6 ตัวอักษร";
 } else{
     $password = trim($_POST["password"]);
 }
 
 // Validate confirm password
 if(empty(trim($_POST["confirm_password"]))){
     $confirm_password_err = "กรุณาใส่รหัสผ่านอีกครั้ง";     
 } else{
     $confirm_password = trim($_POST["confirm_password"]);
     if(empty($password_err) && ($password != $confirm_password)){
         $confirm_password_err = "รหัสผ่านไม่ตรงกัน";
     }
 }
 
 // Check input errors before inserting in database
 if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
     
     // Prepare an insert statement
     $sql = "INSERT INTO user (E_Mail, Firstname, Lastname, Password) VALUES (?, ?, ?, ?)";
      
     if($stmt = mysqli_prepare($conn, $sql)){
         // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt, 'ssss', $param_email, $param_firstname ,$param_lastname, $param_password);
         
         // Set parameters
         $param_email = $email;
         $param_firstname = $firstname;
         $param_lastname = $lastname;
         $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
         
         // Attempt to execute the prepared statement
         if(mysqli_stmt_execute($stmt)){
             // Redirect to login page
             header("location: login.php");
         } else{
             echo "Something went wrong. Please try again later.";
         }

         // Close statement
         mysqli_stmt_close($stmt);
     }
 }
 
 // Close connection
 mysqli_close($conn);
}
?>

<div class="topnav">
<!--
  <a class="active" href="#home">Home</a>
  <a href="#news">News</a>
  <a href="#contact">Contact</a>
  -->
  <div class="topnav-right topnav-hover-red">
    <a href="login.php">เข้าสู่ระบบ</a>
  </div>
</div>
<div class="container">
      <div class="row">
         <div class="col-sm-5 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
               <div class="card-body">
               <h5 class="card-title text-center">สมัครสมาชิก</h5>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="was-validated">
                <div class="row">
                    <div class="col">
                            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                                    <label>ชื่อ </label>
                                    <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>" placeholder="firstname" required>
                                    <span class="text-danger"><?php echo $firstname_err; ?></span>
                            </div>
                    </div>
                    <div class="col">
                            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                                    <label>นามสกุล </label>
                                    <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" placeholder="lastname" required>
                                    <span class="text-danger"><?php echo $lastname_err; ?></span>
                            </div>
                    </div>
                </div>
                
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="Enter email" required aria-describedby="EmailHelpInline">
                        <small id="EmailHelpInline" class="text-muted">
                            ตัวอย่าง: email@example.com
                        </small>
                        <span class="text-danger"><?php echo $email_err; ?></span>
                    </div>    
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" placeholder="Password" required aria-describedby="passwordHelpInline">
                        <small id="passwordHelpInline" class="text-muted">
                        <?php
                            if(strlen($password_err) > 0)
                                echo '<span class="text-danger">'.$password_err.'</span>';
                            else
                                echo 'รหัสความยาว 6-20 ตัวอักษร';
                        ?>  
                        </small>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password" required aria-describedby="cpasswordHelpInline">
                        <small id="cpasswordHelpInline" class="text-muted">
                        <?php
                            if(strlen($confirm_password_err) > 0)
                                echo '<span class="text-danger">'.$confirm_password_err.'</span>';
                            else
                                echo 'รหัสความยาว 6-20 ตัวอักษร';
                        ?>  
                        </small>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-default" value="Reset">
                    </div>
                    <p>Already have an account? <a href="login.php">Login here</a>.</p>
                </form>
                </div>
            </div>
         </div>
      </div>
</div>  

<?php include('model/footer.php'); ?>