<?php
function form_reserv($p){
?> 
<div class="form-area">
<div class="register-area1">
            <div class="container">
              
                <div class="row">
                    <div class="col-md-12">
                        <h3> จองลงทะเบียน</h3>
                        <div class="input-group">
                            <div class="radio">
                                <label><input type="radio" name="optradio">ตรวจรักษาทั่วไป</label>
                              </div>
                            <div class="radio">
                                <label><input type="radio" name="optradio"> ตรวจสุขภาพประจำปี</label>
                              </div>
                            <div class="radio">
                                <label><input type="radio" name="optradio">ตรวจสุขภาพประจำปี(หน่วยงานส่งมา)</label>
                              </div>
                          </div>
                       </div>
                   
                </div>

            </div>   
        </div>
        <input type="hidden" id="pid" value="<?php echo $_SESSION['pid'];?>" />
           <div class="register-area2 border">
            <div class="container">
                <!--<div class="row">
                    <div class="col-md-12 address">
                        <h4>อายุ</h4>
                        <div class="form-group">
                            <input class="form-control"  id="age" />
                        </div>
                      
                       </div>
                   
                </div> -->
                
                <div class="row">
                    <div class="col-md-12">
                        <h4>สิทธิการรักษา</h4>
                        <div class="input-group">
                            <div class="radio">
                                <label><input type="radio" name="right" value="A1$">ชำระเงิน/ข้าราชการ หรือ รัฐวิสหกิจ นำใบเสร็จไปเบิก</label>
                              </div>
                            <div class="radio">
                                <label><input type="radio" name="right" value="A2*"> ข้าราชการเบิกตรง</label>
                              </div>
                            <div class="radio">
                                <label><input type="radio" name="right" value="A23">อบท.เบิกตรง ***สิทธิ์ อบท จะต้องมีการตรวจสอบสิทธิ์อีกครั้ง ณ วันที่มาตรวจจริง***</label>
                              </div>
                            <div class="radio">
                                <label><input type="radio" name="right" value="A7"> ประกันสังคมมหาราชนครเชียงใหม่</label>
                              </div>
                            <div class="radio">
                                <label><input type="radio" name="right" value="UC">ประกันสุขภาพถ้วนหน้าโรงพยาบาลมหาราชนครเชียงใหม่</label>
                              </div>
                          </div>
                       </div>
                   
                </div>
                
                
            </div>   
        </div>
        <div class="register-area3">
            <div class="container">
              
                <div class="row">
                    <div class="col-md-12 address">
                        <h4>ระบุอาการเบื้องต้น</h4>
                        <div class="form-group">
                            <textarea class="form-control" rows="5" id="symptom"></textarea>
                        </div>
                      
                       </div>
                   
                </div> 
                
                 <div class="row">
                        <div class="col-md-12 address">
                            <a target="_blank" href="http://hic.med.cmu.ac.th/mis04/hic/html/opd/opd.php">คลิกเพื่อดูตารางการให้บริการของห้องตรวจ</a>
                        </div>
                </div>
                 <div class="row">
                        <div class="col-md-12 address">
                     <div class="form-group">
                              <label for="exampleInputPassword1">วันที่ต้องการมาตรวจ (วันทำการตั้งแต่วันพรุ่งนี้เป็นต้นไป)</label>
                              <input type="text" class="form-control calendar" id="advanceDate" placeholder="วันที่ต้องการมาตรวจ">                            
                        <div id="dContainer"></div>
                        </div>
                        <div class="form-group">
                              <label for="exampleInputPassword1">หมายเหตุ</label>
                              <textarea class="form-control" rows="5" id="comment"></textarea>                         
                        </div>
                             
                        </div>
                    </div>

                <button id="bt_save_reserv" type="submit" class="btn btn-default">ตกลง</button>
            </div>   
        </div>
</div>
<?php } ?>