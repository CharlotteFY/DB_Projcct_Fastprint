<?php
$point = $conn->query('select Point from user where ID = '.$_SESSION['id'])->fetch_assoc()['Point'];
$rank = $conn->query('select rank from user where ID = '.$_SESSION['id'])->fetch_assoc()['rank'];
$_SESSION['rank'] = $rank;
$_SESSION['point'] = $point;
/*
echo 'Point: '.$point.'</br>';
echo 'Session Fistname: '.$_SESSION['firstname'].'</br>';
echo 'Session Lastname: '.$_SESSION['lastname'];
*/
?>
<!-- nav -->
<div class="topnav">
  <a href="dashboard.php">Dashboard</a>
  <a href="Profile.php" class = "topnav-hover-red">ข้อมูลส่วนตัว</a>
  <a href="History.php" class = "topnav-hover-red">ประวัติ</a>
  <?php
        if(isset($rank) && $rank >= 7)
            echo '<a href="Management.php" class = "topnav-hover-red">จัดการระบบ</a>';
  ?>
  <div class="topnav-right">
    <a href="#">Point: <?php echo $point; ?> ฿</a>
	<a href="logout.php" style="background-color: red">logout</a>
  </div>
</div>