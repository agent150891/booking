(function($){$(function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

mask('form_tel');


function getSms(){//функция получения СМС
  $.ajax({
        url: baseUrl+'sms/smsget',
        type:'post',
        success: function(data){
          data = JSON.parse(data);
          var mess = 'SMS:'+data['message']+' phone:'+data['phone'];
          alert(mess);
        }
  });
}

function setAlert(header, text, clas){
    var al = '<div class="alert alert-dismissable ';
    al += clas;
    al += '"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'
    al += header;
    al += '</strong> <span>';
    al += text;
    al += '</span></div>';
    $('#alert-block').html(al);
}

$('#form_text').click(function(){
    if ($('#form_text').val().trim()=="Текст повідомлення"){
        $('#form_text').val('');
    }
});

$('#send_feed').click(function(){
    var ver = verify([['form_name','name'],['form_text','text'],['form_tel','text']]);
    if (ver){
        var phone= getPhone($('#form_tel').val());
        $.ajax({
            url: baseUrl+'feedSendCode',
            type:'post',
            data:'phone='+phone+'&about=залишаємо відгук'+'&hotel='+$('#hotel_id').val(),
            success: function(data){
                if (data == '0'){
                    $('#feed_form').hide();
                } else{
                    $('#code_but').removeClass('hidden');
                    $('#code_feed').removeClass('hidden');
                    $('#send_feed').addClass('hidden');
                    setAlert('Дякуємо!', 'Ваш зворотній відгук відправлено.', 'alert-success');
                    getSms();
                }
            }
    	});
    }
    return false;
});

$('#code_but').click(function(){//send feed by click
    var ver = verify([['form_name','name'],['form_text','text'],['form_tel','text'],['code_feed','pass']]);
    if (ver){
        var code = $('#code_feed').val();
        var phone= getPhone($('#form_tel').val());
        $.ajax({
            url: baseUrl+'/main/checkcode',
            type:'post',
            data: 'phone='+phone+'&code='+code,
            success: function(data){
                if (data){
                    $('#code_but').addClass('hidden');
                    $('#code_feed').addClass('hidden');
                    $('#send_feed').removeClass('hidden');
                    var feed={};
                    feed.phone = getPhone($('#form_tel').val());
                    feed.name = $('#form_name').val().trim();
                    feed.comment = $('#form_text').val().trim();
                    feed.hotel_id = $('#hotel_id').val();
                    feed.reight = $('#reight').prop('checked');
                    if ($('#reight').prop('checked')){
                        feed.reight = 1;
                    } else{
                        feed.reight = -1;
                    }
                    $.ajax({
                        url: baseUrl+'main/putfeed',
                        type:'post',
                        data: feed,
                        success: function(data){
                            var feeds = JSON.parse(data);
                            var list='';
                            var plus=0;
                            var minus=0;
                            for(i=0;i<feeds.length;i++){
                                if (feeds[i].reight==0){
                                    list += '<div class="feed feed-re">';
                                }else
                                {
                                    list += '<div class="feed">';
                                }
                                list += '<h3>';
                                    if (feeds[i].reight>0){
                                        list += '<span class="plus"></span>';
                                        plus++;
                                    }else if (feeds[i].reight<0) {
                                        list += '<span class="minus"></span>';
                                        minus++;
                                    } else{
                                        list += '<span class="re"></span>';
                                    }
                                list += feeds[i].name;
                                list += '<span class="date">';
                                list += feeds[i].created_at.substr(8,2)+'.'+feeds[i].created_at.substr(5,2)+'.'+feeds[i].created_at.substr(0,4);
                                list += '</span></h3><p>';
                                list += feeds[i].comment;
                                list += '</p><a href="#">Ще</a></div>';
                                if(feeds[i].feed_id > 0){
                                    list += '<div class="feed feed-re">';
                                    list += '<h3><span class="re"></span>'+feeds[i].rname+'</h3>';
                                    list += '<p>'+feeds[i].re+'</p>';
                                    list += '</div>';
                                }
                            }
                            $('#reight_plus').text(plus);
                            $('#reight_minus').text(minus);
                            $('aside.feeds>div').each(function(){
                                $(this).remove();
                            });
                            $('#reight_minus').after(list);
                            $('#all_feeds').removeClass('hidden');
                            $('#form_tel').val('');
                            $('#form_name').val('');
                            $('#form_text').val('    Текст повідомлення');
                          	getSms();
                        }
            	    });
                } else{
                    $('#code_feed').val('не той код');
                }
            }
        });

    }
    return false;
});

})})(jQuery)
