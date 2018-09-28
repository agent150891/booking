(function($){$(function(){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function setAlert(header, text, clas){// tested
    var al = '<div class="alert alert-dismissable ';
    al += clas;
    al += '"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'
    al += header;
    al += '</strong> <span>';
    al += text;
    al += '</span></div>';
    $('#alert-block').html(al);
}

table_click();

function table_click(){//tested
$('.paid_table tr td').each(function(){
  $(this).click(function(){
    $('.paid_table tr').css('font-weight','normal');
    $(this).parent().css('font-weight','bold');
    var id=$(this).parent().find('.hidden').text();
    var name=$(this).parent().find('td:nth-child(2)').text();
    var days=$(this).parent().find('td:nth-child(3)').text();
    var price=$(this).parent().find('td:nth-child(4)').text();
    var cat=$(this).parent().parent().parent().find('thead tr th:first-child').text();
    $('#paid_name').val(name);
    $('#paid_days').val(days);
    $('#paid_price').val(price);
    $('#paid_id').val(id);
    $('#paid_type option').each(function(){
        $(this).removeAttr('selected');
      if ($(this).text()==cat) $(this).attr('selected','');
    });
  });
});
}

$('#but_add').click(function(){//tested
    //добавить услугу
  if (verify([['paid_name','text'],['paid_days','num'],['paid_price','num'],['paid_type','num']])){
    var data=$('#paid_form').serialize();
    $.ajax({
      url: baseUrl+'admin/addPayScheme',
      type:'POST',
      data:data,
      success: function(data){
          if (data == 0){
              $('#paid_id').val(0);
              $('#paid_name').val('');
              $('#paid_days').val('');
              $('#paid_price').val('');
              setAlert('Додавання', 'успішно', 'alert-success');
              $('#paid_type option').each(function(){
                  $(this).removeAttr('selected');
                  if ($(this).val()=='0') $(this).attr('selected','');
              });
              show();
          } else {
              setAlert('Помилка', data, 'alert-danger');
          }
        show();
      }
    });
  }
  return false;
});

$('#but_del').click(function(){//tested
    //удалить услугу
  var id=$('#paid_id').val();
  if (id>0){
    $.ajax({
      url: baseUrl+'admin/delPayScheme',
      type:'POST',
      data:'id='+id,
      success: function(data){
        if (data == 0){
            $('#paid_id').val(0);
            $('#paid_name').val('');
            $('#paid_days').val('');
            $('#paid_price').val('');
            setAlert('Видалення', 'успішно', 'alert-success');
            $('#paid_type option').each(function(){
                $(this).removeAttr('selected');
                if ($(this).val()=='0') $(this).attr('selected','');
            });
            show();
        } else {
            setAlert('Помилка', data, 'alert-danger');
        }

      }
    });
  }
  return false;
});

$('#but_edit').click(function(){//изменить услугу
  if (verify([['paid_name','login'],['paid_days','num'],['paid_price','num'],['paid_type','num']])){
    var name=$('#paid_name').val();
    var days=$('#paid_days').val();
    var price=$('#paid_price').val();
    var id=$('#paid_id').val();
    var type=$('#paid_type').val();
    $.ajax({
      url: baseUrl+'admin/editPayScheme',
      type:'POST',
      data:'paid_name='+name+'&paid_days='+days+'&paid_price='+price+'&paid_id='+id+'&paid_type='+type,
      success: function(data){
          if (data == 0){
              $('#paid_id').val(0);
              $('#paid_name').val('');
              $('#paid_days').val('');
              $('#paid_price').val('');
              setAlert('Корегування', 'успішно', 'alert-success');
              $('#paid_type option').each(function(){
                  $(this).removeAttr('selected');
                  if ($(this).val()=='0') $(this).attr('selected','');
              });
              show();
          } else {
              setAlert('Помилка', data, 'alert-danger');
          }
        show();
      }
    });
  }
  return false;
});


function show(){//tested
  $.ajax({
    url: baseUrl+'admin/showPayScheme',
    type:'POST',
    success: function(data){
      list = JSON.parse(data);
      var l1='';
      var l2='';
      var l3='';
      var l4='';
      var l='';
      for(i = 0; i < list.length; i++){
          l = '<tr class="pointer"><td class="hidden">';
          l += list[i].id;
          l += '</td><td>';
          l += list[i].name;
          l += '</td><td>';
          l += list[i].days;
          l += '</td><td>';
          l += list[i].price;
          l += '</td></tr>';
          if (list[i].type_name=='TOP'){
              l2 += l;
          }
          if (list[i].type_name=='VIP'){
              l1 += l;
          }
          if (list[i].type_name=='Подовжити платне'){
              l3 += l;
          }
          if (list[i].type_name=='Подовжити безкоштовне'){
              l4 += l;
          }
      }
      $('#list1 tbody').html(l1);
      $('#list2 tbody').html(l2);
      $('#list3 tbody').html(l3);
      $('#list4 tbody').html(l4);
      table_click();
      }
  });
}

})})(jQuery)
