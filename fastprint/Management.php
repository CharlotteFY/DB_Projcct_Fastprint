<?php 
$title = 'จัดการระบบ';

include('model/header.php');

// Initialize the session
session_start();

include('model/data.php');
// Check if the user is logged in, if not then redirect him to login page and admin page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['rank'] < 7){
    header("location: login.php");
    exit;
}
?>

<?php
        if(isset($_GET['noti'])) {
          echo "<div class='p-3 mb-2 bg-success text-white' id='notification'>
          ".$_GET['noti']."
          <button type='button' class='close' id=close onclick='closeN()'>
          <i class='fa fa-times' aria-hidden='true'></i>
          </button>
          </div>";
        }
    ?>
<?php
        if(isset($_GET['error'])) {
          echo "<div class='p-3 mb-2 bg-danger text-white' id='notificationError'>
          ".$_GET['error']."
          <button type='button' class='close' id=close onclick='closeNE()'>
          <i class='fa fa-times' aria-hidden='true'></i>
          </button>
          </div>";
        }
    ?>
<div class="container">
<div class="row">
<div class="col-sm-6 col-lg-4">
    <div class="card" style="max-width: 18rem;">
      <div class="card-header bg-dark content-center">
      </div>
      <div class="card-body row text-center">
        <div class="col">
          <div class="text-value-xl bg-warning text-light">
          <?php
           echo ''.mysqli_fetch_array($conn->query('SELECT COUNT(*) FROM user;'))[0].'';
          ?>
          </div>
          <div class="text-uppercase text-muted small"><i class="fa fa-user-o" aria-hidden="true"></i> Users</div>
        </div>
        <div class="vr"></div>
        <div class="col">
          <div class="text-value-xl bg-primary text-light">
                <?php
                echo ''.mysqli_fetch_array($conn->query('SELECT COUNT(*) FROM print;'))[0].'';
                ?>
          </div>
          <div class="text-uppercase text-muted small"><i class="fa fa-print" aria-hidden="true"></i> Prints</div>
        </div>
        <div class="vr"></div>
        <div class="col">
          <div class="text-value-xl bg-success text-light">
                <?php
                echo ''.mysqli_fetch_array($conn->query('SELECT sum(price) FROM print;'))[0].' ฿';
                ?>
          </div>
          <div class="text-uppercase text-muted small">Income</div>
        </div>

      </div>
    </div>
  </div>
</div>
<div class="card-columns" style="column-gap: 0rem;"> 
<div class="card" style="width: 18rem;height: 23rem;">
  <div class="card-body">
    <h5 class="card-title"><i class="fa fa-file-image-o" aria-hidden="true"></i> ราคากระดาษ</h5>
            <form method="post" action="UpdatePrice.php">
                    
                    <div class="form-group">
                        
                        <?php
                            $sql = 'SELECT * FROM `color` WHERE 1;' or die("Error:" . mysqli_error());
                            $colors = $conn->query($sql);

                            while($row = mysqli_fetch_array($colors)) {
                                echo '<label>'.$row['Color'].'</label>
                                <input type="text" name="'.$row["Color"].'" class="form-control" value="'.$row['price'].'" placeholder="ราคา" required>
                                 ';
                            }

                        ?>
                                 
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="อัพเดต">
                        <?php
                          if(isset($_GET['update_paper_price_fail']) && strlen($_GET['update_paper_price_fail']) > 0)
                            echo '<small class="text-danger" role="alert">'.$_GET["update_paper_price_fail"].'</small>';
                          if(isset($_GET['updated_paper_price'])) {
                            echo '<small class="text-success">อัพเดตข้อมูลแล้ว</small>';
                          }
                       ?>
                    </div>
                    
                </form>
                </div>
                        
</div>
<!-- Card -->
<div class="card" style="width: 18rem; height: 23rem;">
  <div class="card-body">
    <h5 class="card-title"><i class="fa fa-print" aria-hidden="true"></i> เพิ่มเครื่องปริ้น</h5>
            <form method="post" action="AddPrinter.php">
                    
                    <div class="form-group">
                        <label>ชื่อสถานที่</label>
                        <input type="text" name="Name" class="form-control" placeholder="ชื่อสถานที่" required>
                        <label>ละติจูด</label>
                        <input type="text" name="latitude" class="form-control" placeholder="latitude" required>
                        <label>ลองจิจูด</label>
                        <input type="text" name="longitude" class="form-control" placeholder="longitude" required>
                                 
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="เพิ่ม">
                        <?php
                          if(isset($_GET['inserted_printer_fail']) && strlen($_GET['inserted_printer_fail']) > 0)
                            echo '<small class="text-danger" role="alert">'.$_GET["inserted_printer_fail"].'</small>';
                          if(isset($_GET['inserted_printer'])) {
                            echo '<small class="text-success">เพิ่มเครื่องปริ้นแล้ว</small>';
                          }
                       ?>
                    </div>
                    
                </form>
                </div>
                        
</div>
<!-- end card -->

<!-- Card -->
<div class="card" style="width: 18rem; height: 23rem;">
  <div class="card-body">
    <h5 class="card-title text-center"><i class="fa fa-cogs" aria-hidden="true"></i> ตั้งค่า</h5>
        <button type="button" class="btn btn-outline-primary" name='show' id="manageBtn" onClick="show()">จัดการเครื่องปริ้น</button>
        
    
</div>
    </div>
                        
</div>
<!-- end card -->
</div>
</div>


</div>

<div id="manageID" style="visibility: hidden;">
           
           <?php
                $sql = "SELECT * FROM printer_location; ";
                $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            echo '<div class="container">
                <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ชื่อสถานที่</th>
                    <th scope="col">latitude</th>
                    <th scope="col">longitude</th>
                    <th scope="col">Maintenance</th>
                    <th scope="col"></th>
                    </tr>
                </thead>';
            while($row = $result->fetch_assoc()) {
                echo '
                <tbody>
                    <tr>
                    <th scope="row">'.$row['ID_Printer'].'</th>
                    <td>'.$row['Name'].'</td>
                    <td>'.$row['latitude'].'</td>
                    <td>'.$row['longitude'].'</td>
                    <td>'.$row['maintenance'].'</td>
                    <td><a class="btn btn-primary" href="editPrinter.php?id='.$row['ID_Printer'].'&Name='.$row['Name'].'&latitude='.$row['latitude'].'&longitude='.$row['longitude'].'&maintenance='.$row['maintenance'].'">Edit</a>
                    <a class="btn btn-danger" method="post" href="deletePrinter.php?id='.$row['ID_Printer'].'">Delete</a></td>
                    </tr>
                </tbody>
                ' ;	
        
            }
	    echo '</table>
            </div>';
} else {
    echo '<main role="main" class="container">
    <br><br>
    <p class="lead"><i class="fa fa-history" aria-hidden="true"> ไม่พบเครื่องปริ้นในระบบ</i></p>
    <p>คุณสามารถเพิ่มเครื่องปริ้นได้หน้า<a href="Management.php"> จัดการระบบ</a> ในเมนู</p>
    </main>';
}

        ?>
</div>

<br>
<script>
function show() {
        if(document.getElementById("manageBtn").name == "show") {
            document.getElementById("manageID").style.visibility = "visible";
            document.getElementById("manageBtn").name = "hide";
            document.getElementById("manageBtn").innerHTML = "ปิดการจัดการเครื่องปริ้น";
            
        } else {
            document.getElementById("manageBtn").name = "show";
            document.getElementById("manageID").style.visibility = "hidden";
            document.getElementById("manageBtn").innerHTML = "จัดการเครื่องปริ้น";

        }
      }
</script>
<script>
function closeN() {
         document.getElementById("notification").style.display = "none";
}
function closeNE() {
         document.getElementById("notificationError").style.display = "none";
}
</script>
</script>
<?php
include('model/footer.php');
?>