<?php 
$title = 'หน้าประวัติ';

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

<?php
            /**
             * History
             * Status = Waiting
             * date -> desc
             */
                $sql = 'SELECT user.ID, printer_location.Name, print.price, print.Status_ID,print.date,print.ID_Data, data.File, status.Status FROM `user` 
                INNER JOIN print on print.ID = user.ID
                INNER JOIN status on status.Status_ID = print.Status_ID
                INNER JOIN printer_location on printer_location.ID_Printer = print.ID_Printer
                INNER JOIN data on data.ID_Data = print.ID_Data
                where user.id = '.$_SESSION["id"].'
                ORDER BY date DESC;' or die("Error:" . mysqli_error());
            
            $recent = $conn->query($sql);

            if($recent->num_rows == 0) {
                echo '
                    
                    <main role="main" class="container">
                    <br><br>
                    <p class="lead"><i class="fa fa-history" aria-hidden="true"> คุณไม่เคยทำรายาการมาก่อน</i></p>
                    <p>คุณสามารถสั่งปริ้นง่ายๆโดยกดไปที่หน้า <a href="dashboard.php"> Dashoard</a> ในเมนู</p>
                    </main>';
            } else {
            
                    echo '
                    
                    <div class="col-sm-5 col-md-7 col-lg-10 mx-auto">
                    <br><br>
                    <i class="fa fa-print" aria-hidden="true"></i> ประวัติการทำรายการ';

                    while($row = mysqli_fetch_array($recent)) {
                       $str = '<div class="card my-2">
                        <div class="card-body">
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$row['File'].'<br>
                            <img src ="picture/Capture2.JPG" width=75 heigh=75>&nbsp&nbsp<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp'.$row["Name"].'
                            <br>
                            ราคา: '.$row["price"].'฿&nbsp&nbsp&nbsp&nbsp<i class="fa fa-calendar" aria-hidden="true"></i> '.$row["date"].' &nbsp&nbsp สถานะ: %'.$row['Status_ID'].'%  
                        </div>
                    </div>';
                    $str = str_replace('%0%', '&nbsp<i class="fa fa-exclamation-triangle text-warning" aria-hidden="true">&nbsp'.$row['Status'].'&nbsp</i>', $str); 
                    $str = str_replace('%1%', '&nbsp<i class="fa fa-check-square text-success" aria-hidden="true">&nbsp'.$row['Status'].'&nbsp</i>', $str); 
                    $str = str_replace('%2%', '&nbsp<i class="fa fa-times text-danger" aria-hidden="true">&nbsp'.$row['Status'].'&nbsp</i>', $str); 
                        
                    
                        echo $str;
                    }

                    //Close tag
                    echo '</div>';
                }
            ?>

<br>

<?php
include('model/footer.php');
?>