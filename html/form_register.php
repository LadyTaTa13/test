<?php
function form_register($p){
?> 
<div class="form-area">
            <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                     <form class="form-submit" id="form_add_member">
                        <div class="form-group">
                          <label for="pid">รหัสประชาชน</label>
                         <input type="number" class="form-control" id="pid" placeholder="รหัสประชาชน" required />                            
                        </div>
                        <div class="form-group">
                              <label for="hn">รหัสผู้ป่วย</label>
                              <input type="number" class="form-control" id="hn" placeholder="รหัสผู้ป่วย" required />                            
                        </div>
                        <div class="form-group">
                            <label for="prefix">คำนำหน้าชื่อ</label>               
                            <select name="prefix" id="prefix" class="form-control" required>
                               <option value="">กรุณาระบุ</option>
                               <option value="1">นาย</option>
                               <option value="2">นาง</option>
                               <option value="3">นางสาว</option>
                               <option value="4">ด.ช.</option>
                               <option value="5">ด.ญ.</option>
                            </select>

                        </div>
                        <div class="form-group">
                              <label for="fname">ชื่อ</label>
                              <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ" required />                            
                        </div>
                        <div class="form-group">
                              <label for="lname">นามสกุล</label>
                              <input type="text" class="form-control" name="lanme" id="lname" placeholder="นามสกุล" required />                            
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
                              <input type="date" name="bdate" class="form-control" id="bdate" placeholder="วันเกิด" required />                            
                        </div>
                        <div class="form-group">
                              <label for="address">บ้านเลขที่</label>
                              <input type="text" name="address" class="form-control" id="address" placeholder="บ้านเลขที่" required />                            
                        </div>
                        <div class="form-group">
                              <label for="moo">หมู่</label>
                              <input type="number" name="moo" class="form-control" id="moo" placeholder="หมู่" required />                            
                        </div>
                        <div class="form-group">
                              <label for="district">ตำบล</label>
                              <input type="text" name="district" class="form-control" id="district" placeholder="ตำบล" required />                            
                        </div>
                        <div class="form-group">
                              <label for="city">อำเภอ</label>
                              <input type="text" class="form-control" name="city" id="city" placeholder="อำเภอ" required />                            
                        </div>
                        <div class="form-group">
                              <label for="province">จังหวัด</label>
                              <input type="text" name="province" class="form-control" id="province" placeholder="จังหวัด" required />                            
                        </div>
                        <div class="form-group">
                              <label for="zipcode">ไปรษณีย์</label>
                              <input type="number" class="form-control" name="zipcode" id="zipcode" placeholder="ไปรษณีย์" required />                            
                        </div>
                         <div class="form-group">
                              <label for="tel">เบอร์โทรบ้าน</label>
                              <input type="tel" class="form-control" id="tel" placeholder="เบอร์โทรบ้าน" required />                            


                        </div>
                        <div class="form-group">
                              <label for="mobile">เบอร์มือถือ</label>
                              <input type="tel" class="form-control" id="mobile" placeholder="เบอร์มือถือ" required />                            

                                      <p class="notice">*เบอร์โทรศัพท์บ้านและมือถือให้พิมพ์ตัวเลขติดกันทั้งหมดไม่ต้องเว้นช่องว่าง หรือ ใส่ขีด เช่น 053945100 หรือ 0812345678</p>

                        </div>
                        <div class="form-group">
                              <label for="email">อีเมลล์</label>
                              <input type="email" class="form-control" id="email" placeholder="อีเมลล์" required />                            
                        </div>
                        
                        <div class="form-group">
                              <label for="psw">รหัสผ่าน</label>
                              <input type="text" class="form-control" id="psw" placeholder="รหัสผ่าน" required />                            


                        </div>
                        <div class="form-group">
                              <label for="re-pwd">ยืนยันรหัสผ่าน</label>
                              <input type="text" class="form-control" name="re-pwd" id="pwd" placeholder="ยืนยันรหัสผ่าน" required />                            
                        </div>
                             <input id="btn_register" type="submit" class="btn btn-default" value="ตกลง">
                      </form>
                    </div>
                 </div>
             
            </div>   
        </div>
<?php } ?>