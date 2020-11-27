<?php 
$title = 'หน้าใช้งาน';

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





    <div class="d-flex justify-content-around">
            <img src="picture/Capture3.JPG" alt="..." >
            <img src="picture/Capture2.JPG" alt="...">
    </div>
    <div class="d-flex justify-content-around">
      <a href="Print.php" class = "A">รูปภาพ</a>
      <a href="Print.php" class = "b">File</a>
    </div>

            <?php
            /**
             * Inprogress
             * Status = Waiting
             * date -> desc
             */
                $sql = 'SELECT user.ID, printer_location.Name, print.price, print.Status_ID,print.ID_Data, data.File,print.date, status.Status FROM `user` 
                INNER JOIN print on print.ID = user.ID
                INNER JOIN status on status.Status_ID = print.Status_ID
                INNER JOIN printer_location on printer_location.ID_Printer = print.ID_Printer
                INNER JOIN data on data.ID_Data = print.ID_Data
                where print.Status_ID = 0 and user.id = '.$_SESSION["id"].'
                ORDER BY date DESC;' or die("Error:" . mysqli_error());

            $recent = $conn->query($sql);

            if($recent->num_rows == 0) {
                echo '
                    
                    <main role="main" class="container">
                    <br><br>
                    <p class="lead"><i class="fa fa-history" aria-hidden="true"> ไม่มีรายการที่รอปริ้นในขณะนี้</i></p>
                    <p>คุณสามารถตรวจสอบ<a href="History.php"> ประวัติการใช้งาน</a> ในเมนู</p>
                    </main>';
            } else {
            
                    echo '
                    
                    <div class="col-sm-5 col-md-7 col-lg-10 mx-auto">
                    <i class="fa fa-print" aria-hidden="true"></i> รายการที่รอปริ้น';

                    while($row = mysqli_fetch_array($recent)) {
                    

                        echo '<div class="card my-2">
                            <div class="card-body">
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$row['File'].'<br>
                            <img src ="picture/Capture2.JPG" width=75 heigh=75>&nbsp&nbsp<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp'.$row["Name"].'</img>
                            <br>
                            ราคา: '.$row["price"].'฿&nbsp&nbsp&nbsp&nbsp<i class="fa fa-calendar" aria-hidden="true"></i> '.$row["date"].' &nbsp&nbsp สถานะ: &nbsp<i class="fa fa-exclamation-triangle text-warning" aria-hidden="true">'.$row["Status"].'</i>  
                        </div>
                    </div>';
                    }

                    //Close tag
                    echo '</div>';
                }
            ?>

<br>
<?php
include('model/footer.php');
?>