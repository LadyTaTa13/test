<?php
function form_profile($p){
?> 
<div class="form-area">
            <div class="container">
             
            <div class="row">
                <div class="col-md-12">
                     <form class="form-submit">
                        <div class="form-group">
                          <label for="pid">รหัสประชาชน</label>
                         <input type="text" class="form-control" id="pid" placeholder="รหัสประชาชน">                            
                        </div>
                        <div class="form-group">
                              <label for="hn">รหัสผู้ป่วย</label>
                              <input type="text" class="form-control" id="hn" placeholder="รหัสผู้ป่วย">                            
                            </div>
                        <div class="form-group">
                            <label for="prefix">คำนำหน้าชื่อ</label>               
                            <select name="prefix" id="prefix" class="form-control">
                                <option>กรุณาระบุ</option>
                                <option>นาย</option>
                                <option>นาง</option>
                                <option>นางสาว</option>
                            </select>
                        </div>
                         <div class="form-group">
                              <label for="fname">ชื่อ</label>
                              <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ">                            
                        </div>
                        <div class="form-group">
                              <label for="lname">นามสกุล</label>
                              <input type="text" class="form-control" name="lanme" id="lname" placeholder="นามสกุล">                            
                        </div>
                        <div class="form-group">
                            <label for="sex">เพศ</label>               
                            <select class="form-control" id="sex">
                                <option value="1">ชาย</option>
                                <option value="2">หญิง</option>
                            </select>
                        </div>
                        <div class="form-group">
                              <label for="bdate">วันเกิด</label>
                              <input type="text" name="bdate" class="form-control" id="bdate" placeholder="วันเกิด">                            
                        </div>
                        <div class="form-group">
                              <label for="address">บ้านเลขที่</label>
                              <input type="text" name="address" class="form-control" id="address" placeholder="บ้านเลขที่">                            
                        </div>
                        <div class="form-group">
                              <label for="moo">หมู่</label>
                              <input type="text" name="moo" class="form-control" id="moo" placeholder="หมู่">                            
                        </div>
                        <div class="form-group">
                              <label for="district">ตำบล</label>
                              <input type="text" name="district" class="form-control" id="district" placeholder="ตำบล">                            
                        </div>
                        <div class="form-group">
                              <label for="city">อำเภอ</label>
                              <input type="text" class="form-control" name="city" id="city" placeholder="อำเภอ">                            
                        </div>
                        <div class="form-group">
                              <label for="province">จังหวัด</label>
                              <input type="text" name="province" class="form-control" id="province" placeholder="จังหวัด">                            
                        </div>
                        <div class="form-group">
                              <label for="zipcode">ไปรษณีย์</label>
                              <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="ไปรษณีย์">                            


                        </div>
                         <div class="form-group">
                              <label for="tel">เบอร์โทรบ้าน</label>
                              <input type="text" class="form-control" id="tel" placeholder="เบอร์โทรบ้าน">                            


                        </div>
                        <div class="form-group">
                              <label for="mobile">เบอร์มือถือ</label>
                              <input type="text" class="form-control" id="mobile" placeholder="เบอร์มือถือ">                            

                                      <p class="notice">*เบอร์โทรศัพท์บ้านและมือถือให้พิมพ์ตัวเลขติดกันทั้งหมดไม่ต้องเว้นช่องว่าง หรือ ใส่ขีด เช่น 053945100 หรือ 0812345678</p>

                        </div>
                        <div class="form-group">
                              <label for="email">อีเมลล์</label>
                              <input type="email" class="form-control" id="email" placeholder="อีเมลล์">                            
                        </div>
                        
                        <div class="form-group">
                              <label for="psw">รหัสผ่าน</label>
                              <input type="text" class="form-control" id="psw" placeholder="รหัสผ่าน">                            


                        </div>
                        <div class="form-group">
                              <label for="re-pwd">ยืนยันรหัสผ่าน</label>
                              <input type="text" class="form-control" name="re-pwd" id="pwd" placeholder="ยืนยันรหัสผ่าน">                            
                        </div>
                             <input id="btn_register" type="button" class="btn btn-default" value="ตกลง">
                      </form>
                    </div>
                 </div>
             
            </div>   
        </div>
<?php } ?>