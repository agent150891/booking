function mask(id){
    var str = "+38 (___) ___-__-__";
    var inp=document.getElementById(id);
    var old="+38 (0";
    var exs = {
        '6': '\\+38 \\(\\d{1}',
        '7': '\\+38 \\(\\d{2}',
        '8': '\\+38 \\(\\d{3}',
        '9': '\\+38 \\([0-9]{3}\\)',
        '10': '\\+38 \\([0-9]{3}\\) ',
        '11': '\\+38 \\([0-9]{3}\\) [0-9]{1}',
        '12': '\\+38 \\([0-9]{3}\\) [0-9]{2}',
        '13': '\\+38 \\([0-9]{3}\\) [0-9]{3}',
        '14': '\\+38 \\([0-9]{3}\\) [0-9]{3}-',
        '15': '\\+38 \\([0-9]{3}\\) [0-9]{3}-[0-9]{1}',
        '16': '\\+38 \\([0-9]{3}\\) [0-9]{3}-[0-9]{2}',
        '17': '\\+38 \\([0-9]{3}\\) [0-9]{3}-[0-9]{2}-',
        '18': '\\+38 \\([0-9]{3}\\) [0-9]{3}-[0-9]{2}-[0-9]{1}',
        '19': '\\+38 \\([0-9]{3}\\) [0-9]{3}-[0-9]{2}-[0-9]{2}'
    };

    inp.onfocus = function(){
        if (inp.value==''){
            inp.value = old;
        }        
    }

    inp.onkeyup = function(event){
        if (inp.value.search(exs[inp.value.length])==-1){
            inp.value=old;
        }
        if (event.keyCode!=8){
            if (inp.value.length==8){
                inp.value+=") ";
            }
            if (inp.value.length==13){
                inp.value+="-";
            }
            if (inp.value.length==16){
                inp.value+="-";
            }
            if (inp.value.length>19){
                inp.value=old;
            }
        }
        old = inp.value;
    }
};

function mask4(id){
    var inp = document.getElementById(id);
    var old ='';
    inp.onkeyup = function(event){
        if (inp.value.search(/^\d{0,4}$/i) == -1){
            inp.value=old;
        } else {
            old = inp.value;
        }
    }
};

function getPhone(phone){
    phone = phone.replace(/\+/,'');
    phone = phone.replace(/\(/,'');
    phone = phone.replace(/\)/,'');
    phone = phone.replace(/[ ]{1}/,'');
    phone = phone.replace(/[-]{1}/,'');
    phone = phone.replace(/[ ]{1}/,'');
    phone = phone.replace(/[-]{1}/,'');
    return phone;
};
