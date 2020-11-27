<?php
	$title = 'First Web';
	include('model/header.php');
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

    <section class="s1">
        <div class="container">
            <div class="h_area">
                <img src="picture/A2.JPG" alt="">
                <h1>Fast print</h1>
                <p>ลักษณะธุรกิจของโปรเจคที่ทำ เป็นบริการรับปริ้นเอกสารออนไลน์
                    ที่สามารถปริ้นได้สะดวกสบายมากขึ้น เพื่อตอบสนองต่อผู้ใช้ ที่เป็นนักศึกษา หรือ
                    บุคคล อื่น
                </p>
            </div>
        </div>
    </section>
    <section class="s2">
        <div class="container">
            <div class="info1_area">
                <img src="#" alt="">
                <h1>รายละเอียดโปรเจค </h1>
                    <p>เป็นบริการรับปริ้นเอกสารออนไลน์ ที่สามารถสั่งปริ้นออนไลน์ได้
                        และมี เอกสารให้เลือกได้ไม่ว่าจะปริ้น photo หรือ file เอกสาร
                    </p>
            </div>
        </div>
    </section>
    <section class="s3">
        <div class="container">
            <div class="info2_area">
                <img src="picture/A2.JPG" alt="">
                    <h1>Requirement</h1>
                    <p> - มีเลือกว่าจะปริ้น photo หรือ file เอกสาร<br>
                        - มีให้เลือกสถานที่ ที่จะปริ้น<br>
                        - มีให้ดูประวัติการปริ้น<br>
                        - มีให้เลือกวิธีการจ่ายเงิน<br>
                    </p>
            </div>
        </div>
    </section>

<?php
	include('model/footer.php');
?>