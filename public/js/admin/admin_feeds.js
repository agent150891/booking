(function($){$(function(){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var start_page = 1;

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

$('#find').click(function(){
    var f = $('#filter').val();
    if (f!='')	filter(start_page);
	return false;
});

function add_pagg(){
    $('#feed_pagg li:first-child').click(function(){
        if (!$(this).hasClass('disabled')){
            console.log('goto page', start_page-1);
            filter(start_page-1);
        }
        return false;
    });

    $('#feed_pagg li:last-child').click(function(){
        if (!$(this).hasClass('disabled')){
            console.log('goto page', start_page+1);
            filter(start_page+1);
        }
        return false;
    });

    $('#feed_pagg li a').each(function(){
        if (parseInt($(this).text())>0){
            $(this).click(function(){
                console.log('goto page', parseInt($(this).text()));
                filter(parseInt($(this).text()));
                return false;
            });
        }
    });
}

function changeFeed(id, status) {
    $.ajax({
        url: baseUrl+'admin/feedSt',
        type:'PUT',
        data:'id='+id+'&status='+status,
        success: function(data){
            if (data == "0"){
                setAlert('Збреження', 'відгуку № '+id+' успішно', 'alert-success');
                filter(start_page);
            } else{
                setAlert('Помилка', data, 'alert-danger');
            }
        }
    });
}

function add_click(){
    $('button.sf').each(function(){
        //подтвердить
        $(this).click(function(){
            var id = $(this).parent().parent().find('td.id').text();
            changeFeed(id, 's');
            return false;
        });
    });
    $('button.bf').each(function(){
        //блокировать
        $(this).click(function(){
            var id = $(this).parent().parent().find('td.id').text();
            changeFeed(id, 'b');
            return false;
        });
    });
    $('button.df').each(function(){
        //удалить
        $(this).click(function(){
            var id = $(this).parent().parent().find('td.id').text();
            changeFeed(id, 'd');
            return false;
        });
    });
}

add_pagg();
add_click();

function filter(page) {
    var f = $('#filter').val();
    $.ajax({
        url: baseUrl+'admin/filterfeeds',
        type:'POST',
        data:'page='+page+'&filter='+f,
        success: function(data){
            var data = JSON.parse(data);
            var list ='';
            for(i = 0; i < data.list.length; i++){
                var feed =data.list[i];
                list += '<tr><td class="id">';
                list += feed.id;
                list += '</td><td>';
                list += feed.title;
                list += '<br>';
                list += feed.owner_name;
                list += ' ';
                list += feed.phone;
                list += '</td><td>'
                list += feed.author_name;
                list += '<br>'
                list += feed.author_phone;
                list += '</td><td class="comment"><p>'
                if (feed.reight > 0){
                    list += '<span class="plus"></span>';
                }
                if (feed.reight < 0){
                    list += '<span class="minus"></span>';
                }
                if (feed.reight == 0){
                    list += '<span class="re"></span>';
                }
                list += feed.comment;
                list += '</p></td><td>'
                if (feed.status == 0){
                    list += 'блокований';
                }
                if (feed.status == 1){
                    list += 'підтверджен';
                }
                if (feed.status == 2){
                    list += 'переглянутий';
                }
                list += '</td><td><button class="btn btn-sm btn-success sf">дозволити</button> <button class="btn btn-sm btn-warning bf">блокувати</button> <button class="btn btn-sm btn-danger df">видалити</button></td></tr>';
            }
            $('#list').html(list);
            $('#pagg_block').html(data.pagg);
            add_click();
            add_pagg();
            start_page = page;
        }
    })
}

})})(jQuery)
