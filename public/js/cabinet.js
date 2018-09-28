(function($){$(function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

$('input[name="phones[]"]').each(function(){
    mask($(this).prop('id'));
});

var k=$('input[name="phones[]"]').length;

$('#add_other_phone').click(function(){
    k=$('input[name="phones[]"]').length;
    if (k<2){
        k++;
        var id = 'phone'+k;
        var inp = '<input type="text" placeholder="+38 (000) 000-00-00" name="phones[]" id="'+id+'">';
        $('form#user_data').append(inp);
        mask(id);
    }
    return false;
});

$('#save_user_info').click(function(){
    switch (k){
        case 0:
            var ver=verify([['change_name','name']]);
            break;
        case 1:
            var ver=verify([['change_name','name'],['phone1','tel']]);
            break;
        case 2:
            var ver=verify([['change_name','name'],['phone1','tel'],['phone2','tel']]);
            break;
    }
    if (ver){
        var f=$('#user_data').serialize();
        $.ajax({
              url: baseUrl+'changeuserdata',
              type:'post',
              data: f,
              success: function(data){
              }
        });
    }
    return false;
});

})})(jQuery)
