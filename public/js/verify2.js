function verify(arr){//функция проверки формы
	var f=true;
	var pass_err=false;
	var pass='';
	for (var i = arr.length - 1; i >= 0; i--){
		test=$("#"+arr[i][0]);
		if (test.val().length>0) test.val(test.val().trim());
		var reg=0;
		if (arr[i][1]=='login') reg=test.val().search(/[a-zA-Z_0-9]{2,}/);
		if (arr[i][1]=='name') reg=test.val().search(/[a-zA-Z_0-9а-яА-Я ]{3,16}/);
		if (arr[i][1]=='text') reg=test.val().search(/.{5,}/);
		if (arr[i][1]=='tel') reg=test.val().search(/\+38 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}/);
		if (arr[i][1]=='num') reg=test.val().search(/\d{1,}/);
		if (arr[i][1]=='email') reg=test.val().search(/\w+@+\w+\.\w{2,5}/i);
        if (arr[i][1]=='date') reg=test.val().search(/^\d{4}-\d{2}-\d{2}$/i);
        if (arr[i][1]=='float') reg=test.val().search(/^\d{2}\.\d{1,}$/i);
		if (arr[i][1]=='pass'){
			reg=test.val().search(/\w{3,}/);
			if (pass=='') pass=test.val();
				else{
					if (pass!=test.val()){
						pass_err=true;
					}
				}
			}
		if (arr[i][1]=='email') reg=test.val().search(/\w{3,}/);
		if (test.val().length<1 || test.val()=="0" || reg==-1 || pass_err==true){
			test.css({"border":"1px red solid"})
			f=false;
		}
		else test.css({"border":"1px #ccc solid"});
	}
if (f==true) return true; else return false;
}
