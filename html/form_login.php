<?php
function form_login($p){
	?>
	       <div class="main-content">
            <div class="container">
              
                <div class="row">
                    <div class="col-md-6">
                        <h3>ข้อกำหนดของระบบลงทะเบียนผู้ป่วยล่วงหน้า</h3>
                        <p><b>ท่านที่มีนัดกับทาง รพ.อยู่แล้วไม่จำเป็นต้องจองผ่านระบบนี้</b></p>
                        <p>ระบบนี้อำนวยความสะดวกเพื่อลดขั้นตอนให้ท่านไม่ต้องไปติดต่อลงทะเบียน และติดต่อศูนย์คัดกรอง ท่านสามารถไปที่หน้าห้องตรวจได้เลย และเมื่อไปถึงหน้าห้องตรวจแล้วขอความกรุณาแจ้งกับพยาบาลหน้าห้องตรวจว่า ได้ทำการลงทะเบียนออนไลน์มาแล้ว</p>
                        <p><b>ระบบนี้มิใช่การจองคิวเพื่อจัดลำดับการเข้าพบแพทย์</b></p>
                        <p>หลังจากจองลงทะเบียนตรวจล่วงหน้าแล้ว กรุณารอรับข้อความSMSจาก รพ. ซึ่งถ้าช่วงเวลาที่ท่านทำรายการเป็นช่วงนอกเวลาราชการ หรือวันหยุดราชการ กรุณารอรับข้อความSMSในวันเปิดทำการถัดไป</p>
                        <p class="notice">* เปิดบริการเฉพาะ ผู้ป่วยชำระเงิน ข้าราชการ/รัฐวิสาหกิจนำใบเสร็จไปเบิก ข้าราชการเบิกตรง ประกันสังคมมหาราชนครเชียงใหม่ ประกันสุขภาพถ้วนหน้าโรงพยาบาลมหาราชนครเชียงใหม่</p>
                    </div>
                    <div class="col-md-6">
                        <img class="img-thumbnail" src="images/photo-hospital.png" >
                    </div>
                </div>
            </div>   
        </div>
        <?php if(!isset($_SESSION['uid'])){?>
	        <div class="login-area" >

<div class="container">
    <h3 class="form-signin-heading text-muted">ท่านที่เคยลงทะเบียนสมาชิกแล้วเชิญล็อคอินเพื่อจองการตรวจได้เลยจ้ะ</h3>
	<form class="form-signin">
		
            <input type="text" id="pid" class="form-control" placeholder="เลขประจำตัวประชาชน " required="" autofocus="">
            <input id="psw" type="password" class="form-control" placeholder="รหัสผ่าน" required="">
		<input id="btn_login" class="btn btn-lg btn-primary btn-block" value="Login" type="button">
		
		
	</form>

</div>
        </div>
	<?php
        }
}
?>