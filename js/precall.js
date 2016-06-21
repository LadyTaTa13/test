function precall(params) {
	if(params.output===undefined){ params.output='json';}
    switch (params.method) {
		
		case 'login':
		{
		var u=$('#pid').val();	
                var p=$('#psw').val();	
                
                if(u == "" || p ==""){
                    alert('กรุณากรอก Username หรือ password');
                    return;
                }
		}break;
                case 'reserv':
		{
                    alert('reserve');
                    params.right=$('input[name="right"]:checked').val();
                    params.adv=$('#advanceDate').val();
                    params.symptom=$('#symptom').val();
 
		}break;
                 case 'form_reserv':{
                            alert('precall-form_reserv');
        }break;
        
        

                
   }
   CallMethod(params);
}