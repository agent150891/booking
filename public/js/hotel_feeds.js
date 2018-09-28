(function($){$(function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

var feeds = [];
var num = 0;

$.ajax({
    url: baseUrl+'feeds/getlist',
    type: 'POST',
    data: 'hotel_id='+$('#hotel_id').val(),
    success: function(rdata){
        feeds = JSON.parse(rdata);
    }
});

function fut(){
    if (feeds.length > (num)){
        console.log(feeds[num].re);
        if (feeds[num].re == ''){//next feed no re
            $('#next_feed').attr('data-target','#view_feed_empty');
            console.log('change to #view_feed_empty');
            return true;
        } else{
            $('#next_feed').attr('data-target','#view_feed');
            console.log('change to #view_feed');
            return false;
        }
    } else {
        console.log('end of list');
        return false;
    }
}

function saveFeed(){
    var feed = feeds[num];
    feed.status =2;
    $.ajax({
        url: baseUrl+'feeds/save',
        type: 'POST',
        data: feed,
        success: function(rdata){
            //console.log(rdata);
        }
    });
}

function setRead(){
    var n=num+2;
    $('.feeds-edit>aside:nth-child('+n+') div:nth-child(5)').text('Прочитаний');
    $('.feeds-edit>aside:nth-child('+n+') button').text('Переглянути');
    $('.feeds-edit>aside:nth-child('+n+') button').removeClass('btn-danger');
    $('.feeds-edit>aside:nth-child('+n+') button').addClass('btn-default');
}

$('.feeds-edit>aside>button').each(function(){
    $(this).click(function(){
        num = parseInt($(this).next().val());
        var n=num+2;
        saveFeed();
        $('#feed_name').text(feeds[num].name+' '+feeds[num].phone);
        $('#feed_name_empty').text(feeds[num].name+' '+feeds[num].phone);
        var comment = '';
        if (feeds[num].reight>0){
            comment += '<span class="plus"></span>';
        }
        if (feeds[num].reight<0){
            comment += '<span class="minus"></span>';
        }
        if (feeds[num].reight==0){
            comment += '<span class="re"></span>';
        }
        comment += feeds[num].comment;
        $('#feed_comment').html(comment);
        $('#feed_re').html('<span class="re"></span>'+feeds[num].re);
        $('#feed_comment_empty').html(comment);
        setRead();
    });
});

$('#next_feed').click(function(){
    if ((num+1)<feeds.length){
        num++;
        $('#feed_name').text(feeds[num].name+' '+feeds[num].phone);
        $('#feed_name_empty').text(feeds[num].name+' '+feeds[num].phone);
        $('#feed_comment').text(feeds[num].comment);
        $('#feed_re').html('<span class="re"></span>'+feeds[num].re);
        $('#feed_comment_empty').html(feeds[num].comment);
        saveFeed();
        setRead();
        return fut();
    }
    return false;
});
console.log('21.06');
$('#open_feed_view').click(function(){
    var ver = verify([['re','text']]);
    var re = $('#re').val().trim();
    feeds[num].re = re;
    $('#feed_re').html('<span class="re"></span>'+feeds[num].re);
    if (ver){
        $.ajax({
            url: baseUrl+'feeds/re',
            type: 'POST',
            data: 'id='+feeds[num].id+'&re='+re,
            success: function(rdata){
                console.log(rdata);
                var n=num+2;
                $('.feeds-edit>aside:nth-child('+n+') button').each(
                    function(){
                        $(this).prop('data-target','#view_feed');
                    }
                );
                $('.feeds-edit>aside:nth-child('+n+') button').attr('data-target','#view_feed');
            }
        });
        return true;
    }
});

$('#open_feed_re').click(function(){
    $('#feed_name_re').text(feeds[num].name+' '+feeds[num].phone);
});
/*
$('.feeds-edit>aside:nth-child('+(3+1)+') div:nth-child(5)').text('Прочитаний');
$('.feeds-edit>aside:nth-child('+(3+1)+') button').text('Переглянути');
$('.feeds-edit>aside:nth-child('+(3+1)+') button').removeClass('btn-danger');
$('.feeds-edit>aside:nth-child('+(3+1)+') button').addClass('btn-default');*/

})})(jQuery)
