<?php
function form_reserv($p){
?> 
<div class="form-area">
            <div class="container">
             
            <div class="row">
                <div class="col-md-12">
                     <form class="form-submit">
                        <div class="form-group">
                          <label for="idCard">รหัสประจำตัวประชาชน</label>
                         <input type="text" class="form-control" id="pid" placeholder="รหัสประจำตัวประชาชน">                            
                        </div>
                        <div class="form-group">
                              <label for="exampleInputEmail1">HN</label>
                              <input type="text" class="form-control" id="hn" placeholder="รหัสผู้ป่วย">                            
                            </div>
                        <div class="form-group">
                            <label for="">สิทธิการรักษา</label>               
                            <select name="prefix" id="prefix" class="form-control">
                                <option>กรุณาระบุ</option>
                                <option>นาย</option>
                                <option>นาง</option>
                                <option>นางสาว</option>
                            </select>
                        </div>
                         <div class="form-group">
                              <label for="exampleInputPassword1">ชื่อ</label>
                              <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ">                            
                        </div>
                        <div class="form-group">
                              <label for="exampleInputPassword1">นามสกุล</label>
                              <input type="text" class="form-control" name="lanme" id="lname" placeholder="นามสกุล">                            
                                                    
                        </div>
                        
                             <input id="btn_register" type="button" class="btn btn-default" value="ตกลง">
                      </form>
                    </div>
                 </div>
             
            </div>   
        </div>
<?php } ?>