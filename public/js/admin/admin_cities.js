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

function addClick(){
    $('#list tr').each(function(){
        $(this).click(function() {
            var id = $(this).find('td.hidden').text();
            var alt = $(this).find('td.alt').text();
            var lng = $(this).find('td.lng').text();
            var name = $(this).find('td.city').text();
            $('#e_city_name').val(name);
            $('#e_alt').val(alt);
            $('#e_lng').val(lng);
            $('#e_city_id').val(id);
        });
    });
}

addClick();

function citiesList() {
    $.ajax({
        url: baseUrl+'admin/citiesList',
        type:'POST',
        success: function(data){
            var cities = JSON.parse(data);
            var list = '';
            for (var i = 0; i < cities.length; i++) {
                list += '<tr class="pointer"><td class="hidden">';
                list += cities[i].id;
                list += '</td><td class="city">';
                list += cities[i].city;
                list += '</td><td class="alt">';
                list += cities[i].gps_alt;
                list += '</td><td class="lng">';
                list += cities[i].gps_lng;
                list += '</td></tr>';
            }
            $('#list').html(list);
            addClick();
        }
    });
}

$('#e_city_but').click(function(){
    var ver = verify([
        ['e_city_name','name'],
        ['e_alt','float'],
        ['e_lng','float'],
    ]);
    if (ver){
        var form = $('#edit_city_form').serialize();
        $.ajax({
            url: baseUrl+'admin/editCity',
            type:'POST',
            data: form,
            success: function(data){
                if (data == '0'){
                    setAlert('Редагування', 'виконано' , 'alert-success');
                    citiesList();
                } else{
                    setAlert('Помилка', data, 'alert-danger');
                }
            }
        });
    }
    return false;
});

$('#add_city').click(function(){
    var ver = verify([
        ['new_city_name','name'],
        ['new_alt','float'],
        ['new_lng','float'],
    ]);
    if (ver){
        $('#new_city_name').val('');
        $('#new_alt').val('');
        $('#new_lng').val('');
        var form = $('#new_city_form').serialize();
        $.ajax({
            url: baseUrl+'admin/addCity',
            type:'POST',
            data: form,
            success: function(data){
                if (data == '0'){
                    setAlert('Додавання', 'виконано' , 'alert-success');
                    citiesList();
                } else{
                    setAlert('Помилка', data, 'alert-danger');
                }
            }
        });
    }
    return false;
});


})})(jQuery)
