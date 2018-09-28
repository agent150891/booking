(function($){$(function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

var start_page=1;

function add_pagg(){
    $('#room_pagg li:first-child').click(function(){
        if (!$(this).hasClass('disabled')){
            room_pagg(start_page-1);
        }
        return false;
    });

    $('#room_pagg li:last-child').click(function(){
        if (!$(this).hasClass('disabled')){
            room_pagg(start_page+1);
        }
        return false;
    });

    $('#room_pagg li a').each(function(){
        if (parseInt($(this).text())>0){
            $(this).click(function(){
                room_pagg(parseInt($(this).text()));
                return false;
            });
        }
    });
}

add_pagg();

function room_pagg(page){
    $.ajax({
          url: baseUrl+'room/paggination',
          type:'post',
          data:'page='+page+'&hotel_id='+$('#hotel_id').val(),
          success: function(data){
            data = JSON.parse(data);
            var list = '';
            for(var i = 0; i < data.list.length; i++){
                list += '<aside><div class="photo"><img src="/storage/app/';
                list += data.list[i].foto1;
                list += '" alt="room_photo"><img src="../img/images.png" alt="images" class="images"></div><div class="content"><h3>';
                list += data.list[i].title;
                list += '</h3><div><ul><li><img src="../img/bed.png" alt="bed"><div class="info-bed">Кількість спальних місць</div><span>';
                list += data.list[i].beds;
                list += '</span></li><li><img src="../img/wi-fi.png" alt="wifi"><div class="info-wifi">WI-FI</div><span>';
                list += (data.list[i].wifi > 0) ? 'Так':'Ні';
                list += '</span></li><li><img src="../img/bath.png" alt="bath"><div class="info-bath">Душ у номері</div><span>';
                list += (data.list[i].bath > 0) ? 'Так':'Ні';
                list += '</span></li><li><img src="../img/wc.png" alt="wc"><div class="info-wc">Туалет у номері</div><span>';
                list += (data.list[i].wc > 0) ? 'Так':'Ні';
                list += '</span></li><li><img src="../img/cond.png" alt="cond"><div class="info-cond">Кондіціонер</div><span>';
                list += (data.list[i].cond > 0) ? 'Так':'Ні';
                list += '</span></li><li><img src="../img/tv.png" alt="tv"><div class="info-tv">Телевізор</div><span>';
                list += (data.list[i].tv > 0) ? 'Так':'Ні';
                list += '</span></li><li><img src="../img/kitchen.png" alt="kitchen"><div class="info-kitchen">Кухня</div><span>';
                list += (data.list[i].kitchen > 0) ? 'Так':'Ні';
                list += '</span></li></ul></div><div><img src="../img/phone.png" alt="phone"><span class="phone">';
                list += $('#phone').val();
                list += '</span></div><article>';
                list += data.list[i].about;
                list += '</article><div class="grey"></div><div class="details">від <span>';
                list += data.list[i].price;
                list += '</span> грн/доба<a href="../room/';
                list += data.list[i].id;
                list += '" class="btn btn-success pull-right">Детальніше</a></div></div></aside>'
            }
            list += data.pagg;
            $('#room_list').html(list);
            start_page = page;
            add_pagg();
          }
      });
}

})})(jQuery)
