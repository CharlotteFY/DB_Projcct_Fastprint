<?php 
$title = 'หน้าPrint';

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
               * init location
               */
              $sql = 'SELECT * FROM `printer_location` WHERE printer_location.maintenance = 0;' or die("Error:" . mysqli_error());
          
              $loc = $conn->query($sql);

              

?>

    <section>
    <div class="card">
    <?php
        if(isset($_GET['error'])) {
          echo "<div class='p-3 mb-2 bg-danger text-white' id='notification'>
          ".$_GET['error']."
          <button type='button' class='close' id=close onclick='closeN()'>
          <i class='fa fa-times' aria-hidden='true'></i>
          </button>
          </div>";
        }
    ?>
  <div class="card-header">
    กรุณาเลือก
  </div>
  <div class="card-body">
  <form class="was-validated" action="pay.php" method="post" novalidate>
  
  <div class="form-row">
  <input type="file" name=file id="fileInput" accept="application/pdf, application/vnd.ms-excel, image/gif, image/jpeg, image/png" required>
  </div>
  <div class="form-row">
  
    <div class="col-md-3 mb-3">
      <label for="location">สถานที่</label>
      <select class="custom-select" id="location" name='location' required>
          <?php
              if($loc->num_rows > 0) {
                while($row = mysqli_fetch_array($loc)) {
                  echo "<option>[".$row['ID_Printer']."] ".$row['Name']."</option>";
                }
                
              }
          ?>
      </select>
      <?php
          if($loc->num_rows == 0) {
            echo '<small class="text-danger">ไม่พบเครื่องที่พร้อมใช้งานในขณะนี้';
        }
      ?>
    </div>
  </div>
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">สี</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="colors" id="colors" value="0" checked>
          <label class="form-check-label" for="gridRadios1">
            สีขาวดำ
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="colors" id="colors" value="1">
          <label class="form-check-label" for="gridRadios2">
            หลากสี
          </label>
        </div>
      </div>
    </div>
  </fieldset>
  </fieldset>
  <div class="form-group row">
    <div class="col-sm-2">payment</div>
    <div class="col-sm-10">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="payment" name='payment' value="point" checked required>
        <label class="form-check-label" for="payment">
          Point
        </label>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-3 mb-3">
      <label for="validationTooltip04">จำนวนหน้า</label>
      <select name='pages' class="custom-select" id="validationTooltip04" required>
        
        <?php
            
            for($i=1;$i<=50;++$i){
                echo '<option value='.$i.'>'.$i.'</option>';
            }
        ?>
      </select>
      
    </div>
  </div>
 
  <button class="btn btn-primary" type="submit">Submit form</button>
</form>
  </div>
</div>

 <script>
      document.getElementById('fileInput').onchange = function () {
        document.getElementById("filename").value = this.value.split("\\").pop();
      };
}
</script>
<script>
function closeN() {
         document.getElementById("notification").style.display = "none";
      }
</script>
<?php
include('model/footer.php');
?>