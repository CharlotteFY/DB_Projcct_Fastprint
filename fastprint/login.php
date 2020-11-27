<?php
 
$title = 'เข้าสู่ระบบ';
// Include config file
require_once "model/header.php";
 
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]){
    header("location: dashboard.php");
    exit;
}

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "กรุณาใส่ Email";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "กรุณาใส่รหัสผ่าน";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT ID,Firstname, Lastname, E_Mail, rank, Password FROM user WHERE E_Mail = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $Firstname, $Lastname, $E_Mail, $rank, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                       
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $E_Mail;
                            $_SESSION["firstname"] = $Firstname;                          
                            $_SESSION["lastname"] = $Lastname;
                            $_SESSION["rank"] = $rank;
                            // Redirect user to welcome page
                            header("location: dashboard.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "รหัสผ่านไม่ถูกต้อง";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "ไม่พบผู้ใช้นี้";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <a href="#">เข้าสู่ระบบ</a>
  </div>
</div>
<div class="container">
      <div class="row">
         <div class="col-sm-5 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
               <div class="card-body">
               <h5 class="card-title text-center">เข้าสู่ระบบ</h5>
               
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="was-validated" method="post">
                        <div class="form-group">
                           <label for="vEmail">Email:</label>
                           <input type="email" class="form-control" id="vEmail" placeholder="Enter email" name="email" required>
                           <small id="passwordHelpInline" class="text-muted">
                           <?php
                            echo '<span class="text-danger">'.$email_err.'</span>';
                        ?>  
                        </small>
                        </div>
                     <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required required aria-describedby="passwordHelpInline">
                        <small id="passwordHelpInline" class="text-muted">
                        <?php
                            echo '<span class="text-danger">'.$password_err.'</span>';
                        ?>  
                        </small>
                  </div>
                  
                  <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
				  <center><a href="register.php">สมัครสมาชิก</a></center>
			   </form> 
               </div>
            </div>
         </div>
      </div>
</div>

<?php include('model/footer.php') ?>