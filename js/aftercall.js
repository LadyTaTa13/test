function aftercall(params,data){
	switch(params.method){
		case 'form_login':
		{
                    $('#btn_login').click(function(){
                        var u=$('#pid').val();
                        var p=$('#psw').val();
                        precall({method:'login',pid:u,psw:p});
                    });
                    $('#psw,#pid').keypress(function(){
                        if (event.which == 13) {
                             var u=$('#pid').val();
                             var p=$('#psw').val();
                             precall({method:'login',pid:u,psw:p});
                        }
                       
                    });
			precall({method:'menu',output:'html',display:'showMenu'});
		}break;
        case 'form_profile':
        {
             precall({method:'get_profile'});
           
        }break;
        case 'form_register':
        {
            //  alert(JSON.stringify(data));
            $('form#form_add_member').on('click','#btn_register',function(){
                
               if (!$('form#form_add_member').checkValidity || $('form#form_add_member').checkValidity()) {

                    alert("Thanks!!");
                    var pid=$('#pid').val();
                    var hn=$('#hn').val();
                    var prefix=$('#prefix').val();
                    var fname=$('#fname').val();
                    var lname=$('#lname').val();
                    var sex=$('#sex').val();
                    var bdate=$('#bdate').val();
                    var address=$('#address').val();
                    var moo=$('#moo').val();
                    var district=$('#district').val();
                    var city=$('#city').val();
                    var province=$('#province').val();
                    var zipcode=$('#zipcode').val();
                    var tel=$('#tel').val();
                    var mobile=$('#mobile').val();
                    var email=$('#email').val();
                    var psw=$('#psw').val();
                    var pwd=$('pwd').val();
                    precall({method:'add_member',pid:pid,hn:hn,prefix:prefix,fname:fname,lname:lname,sex:sex,bdate:bdate,address:address,moo:moo,district:district,city:city,province:province,zipcode:zipcode,tel:tel,mobile:mobile,email:email,psw:psw,pwd:pwd});
                }
               });

        }break;
        case 'form_reserv':
        {
            alert('form_reserv');
            var mt;
            var $input = $( '.calendar' ).pickadate({
				format: 'yyyy-mm-dd',
                formatSubmit: 'yyyy-mm-dd',
                // min: [2015, 7, 14],
                container: '#dContainer',
                // editable: true,
                closeOnSelect: true,
                closeOnClear: false,
    			onSet:function(){
    				
    			}
            })
    
            var picker = $input.pickadate('picker');
        
             $('input[name="right"]').click(function(){
                 var right=$(this).val();
                 
                 if(right=='A2*'){
                     mt="CHECK_RIGHT_OFFICIAL_BY_PID";
                 }else if(right=='A23'){
                     mt="CHECK_RIGHT_OFFICIAL1_BY_PID";
                 }else if(right=='A7'){
                     mt="CHECK_RIGHT_SSN_BY_PID";
                 }else if(right=='UC'){
                     mt="CHECK_RIGHT_NHSO_BY_PID";
                 }
                 if(mt=='CHECK_RIGHT_NHSO_BY_PID'){
                     precall({method:'CHECK_RIGHT_NHSO_BY_PID',pid:$('#pid').val()});
                 }else{
                    precall({method:'webservice',service_nm:mt,pid:$('#pid').val()});
                 }
             });
             
             precall({method:'reserv',output:'json'});
             
        }break;
         case 'get_profile':
        {
             var x = data;
             $('#pid').val(data._value.pid);
             $('#hn').val(data._value.hn);
             $('#prefix').val(data._value.ttl_code);
             $('#fname').val(data._value.fnm);
             $('#lname').val(data._value.lnm);
             $('#sex').val(data._value.sex);
             $('#bdate').val(data._value.birthdate);
             $('#address').val(data._value.address);   
             $('#moo').val(data._value.moo);
             $('#district').val(data._value.tumbol);
             $('#city').val(data._value.aumphur);
             $('#province').val(data._value.province);
             $('#zipcode').val(data._value.zipcode);
             $('#tel').val(data._value.tel);
             $('#mobile').val(data._value.mobile);
             $('#email').val(data._value.email);

             $('#btn_update_profile').on('click',function(){
                 precall({method:'update_profile',
                          pid:$('#pid').val(),
                          hn:$('#hn').val(),
                          ttl_code:$('#prefix').val(),
                          fnm:$('#fname').val(),
                          lnm:$('#lname').val(),
                          sex:$('#sex').val(),
                          birthdate:$('#bdate').val(),
                          address:$('#address').val(),
                          moo:$('#moo').val(),
                          tumbol:$('#district').val(),
                          aumphur:$('#city').val(),
                          province:$('#province').val(),
                          zipcode:$('#zipcode').val(),
                          tel:$('#tel').val(),
                          mobile:$('#mobile').val(),
                          email:$('#email').val(),
                          psw:$('#psw').val(),
                          psw2:$('#pwd').val()});
             });
        }break;
        case 'update_profile':{
           var x=data;
           alert(x);
            
        }break;
        case 'login':{
            precall({method:'menu',output:'html',display:'showMenu',callback:function(){$('#btn_profile').click()}}); 
            
        }break;
        case 'logout':{
            precall({method:'menu',output:'html',display:'showMenu',callback:function(){$('#btn_form_login').click()}}); 
        }break;
        case 'table_list_history':{
                
            precall({method:'list_history',output:'json'});
            $('.child-detail').parent().hide();
            $('.normal_clicker').on('click',function(){
               // $('.normal_clicker').css({'background-color':'#f9f9f9','color':'#000'}).next().hide();
            $(this).toggleClass('high-light-title').next().toggle();
            
            
            });
        }break;
        case 'menu':
		{
                    $('#btn_form_login').click(function(){
                        precall({method:'form_login',output:'html',display:'showData'});
                    });
                    $('#btn_register').click(function(){
                        precall({method:'search_member',output:'html',display:'showData'});
                    });
                    $('#btn_profile').click(function(){
                        precall({method:'form_profile',output:'html',display:'showData'});
                    });
                    $('#btn_reserv').click(function(){
                       // alert('ก่อนจองท่านต้องแน่ใจว่า ท่านไม่มีการนัดกับโรงพยาบาลอยู่ก่อนแล้ว หากท่านทำการจองซ้ำซ้อนกับวันที่มีนัดอยู่แล้ว อาจทำให้ได้รับบริการที่ช้าลง');
                       alert('clicked');
                        precall({method:'form_reserv',output:'html',display:'showData'});
                       alert('next aftercall');
                    });
                    $('#btn_history').click(function(){
                        precall({method:'table_list_history',output:'html',display:'showData'});
                    });
                    $('#btn_appoint').click(function(){
                        precall({method:'list_appoint',output:'html',display:'showData'});
                    });
                    $('#btn_contact_us').click(function(){
                        precall({method:'contact_us',output:'html',display:'showData'});
                    });
                    $('#btn_logout').click(function(){
                        precall({method:'logout'});
                    });
                    $("#main_menu li a").click(function(){
                        $(".active").removeClass("active");
                        $(this).parent().addClass("active");
                    });
                    
                    if(!(params.callback===undefined)){
                        eval(params.callback());
                    }
                    
                    $('#main_menu').on('click','li',function(){
                         if (!$(this).parent().hasClass('dropdown'))
                            $(".navbar-collapse").collapse('hide'); 
                      });
		}break;
		case 'search_member':{
                     $('.btn_search_member').on('click',function(){
                       var id_mem = $('#search_member').val();
                        precall({method:'check_oprdb',pid:id_mem});
                        
                        
                    });
                }break; 
                case 'check_oprdb':{
                    if(data._value == 0 ){
                            alert('ไม่พบข้อมูล กรุณาสมัครสมาชิก');
                            precall({method:'form_profile',output:'html',display:'showData'});
                    }
                    else{
                        alert('คุณได้เคยทำการสมัครแล้วค่ะ');
                        precall({method:'form_login',output:'html',display:'showData'});
                    }
                }break; 
                 
	 case 'list_history':{
                 alert();
                  var y =  data;
                }break; 
	}
       

}