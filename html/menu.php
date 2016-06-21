<?php
function menu($p){
?>
<nav class="navbar navbar-default">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button"  class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
           
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              
            <ul class="nav navbar-nav" id="main_menu">
              <li class="active"><a id="btn_form_login">หน้าหลัก<span class="sr-only">(current)</a></span></li>
              <?php if(!isset($_SESSION['uid'])){?>
                <li><a id="btn_register">สมัครสมาชิก</a></li>
              <?php }else{?>
                <li><a id="btn_profile">ข้อมูลส่วนตัว</a></li>
                <li><a id="btn_reserv">จองลงทะเบียน</a></li>
                <li><a id="btn_history">ประวัติการลงทะเบียน</a></li>
                <li><a id="btn_appoint">ประวัติการนัด</a></li>
                <li><a id="btn_logout">ออกจากระบบ</a></li>
              <?php }?>
              <li><a id="btn_contact_us">ติดต่อสอบถาม</a></li>

            </ul>
            <form class="navbar-form navbar-right" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="วันเปิดทำการของห้องตรวจ">
              </div>
              <button type="submit" class="btn btn-default">ค้นหา</button>
            </form>

          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
<div class="topic-tag">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>ระบบลงทะเบียนผู้ป่วยล่วงหน้าผ่านเครือข่ายอินเตอร์เน็ต โรงพยาบาลมหาราชนครเชียงใหม่</h2>
                    </div>
                </div>
            </div>
        </div>
<?php
}
?>