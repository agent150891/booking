(function($){$(function(){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#find').click(function(){// tested
	if (filter!='')	adds_filter();
	return false;
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

$('#user_list tr').each(function(){
    $(this).click(function() {
        var id = $(this).find('td.hidden').text();
        $.ajax({
            url: baseUrl+'admin/userinfo/'+id,
            type:'GET',
            success: function(data){
                if (data == '0'){
                    rooms(hotel_id);
                    setAlert('Помилка', 'некорректний id користувача', 'alert-danger');
                } else{
                    var data =JSON.parse(data);
                    var user = data.user;
                    $('#user_id').val(user.id);
                    $('#user_name').text(user.name);
                    $('#user_date').text(user.created_at);
                    switch (user.role){
                        case 0:
                            $('#user_role').text('Видалений');
                            break;
                        case 1:
                            $('#user_role').text('Користувач');
                            break;
                        case 2:
                            $('#user_role').text('Адмін');
                            break;
                        default:
                            $('#user_role').text('невідомий');
                            break;
                    }
                    var phones = data.phones;
                    var list = '';
                    for(i = 0; i < phones.length; i++){
                        list +=' Тел.'+(i+1)+': '+phones[i].phone+'<br>';
                    }
                    $('#user_phones').html(list);
                }
            }
        });
    });
});

$('#set_but').click(function(){
    var id = $('#user_id').val();
    if (id>0){
        var status = $('#status').val();
        if (status>-1){
            $.ajax({
                url: baseUrl+'admin/usersave',
                type:'POST',
                data:'id='+id+'&status='+status,
                success: function(data){
                    if (data=='0'){
                        setAlert('Збереження', 'статус змінено', 'alert-success');
                        switch (status){
                            case '0':
                                $('#user_role').text('Видалений');
                                break;
                            case '1':
                                $('#user_role').text('Користувач');
                                break;
                            case '2':
                                $('#user_role').text('Адмін');
                                break;
                            default:
                                $('#user_role').text('невідомий');
                                break;
                        }
                    } else{
                        setAlert('Помилка', data, 'alert-danger');
                    }
                }
            });
        } else{
            setAlert('Попередження', 'оберіть статус', 'alert-warning');
        }
    } else{
        setAlert('Попередження', 'оберіть користувача зі списку', 'alert-warning');
    }
    return false;
});

})})(jQuery)
