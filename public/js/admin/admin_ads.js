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
var hotel_id = 0;

console.log('new 27/06');

function adds_filter(){// tested
    var filter=$('#filter').val().trim();
	$.ajax({
		url: baseUrl+'admin/filterhotels',
		type:'POST',
		data:'filter='+filter,
		success: function(data){
            //console.log(data);
            var hotels = JSON.parse(data);
            var list ='';
            for(i=0;i<hotels.length;i++){
                var hotel =hotels[i];
                list += '<tr>';
				list += '<td>'+hotel.id+'</td>';
			    list += '<td>'+hotel.title+'</td>';
			    list += '<td>'+hotel.phone+'</td>';
				list += '<td>бекоштовне</td>';
				list += '<td>';
			    list += '<button class="btn btn-xs btn-success">піднять</button> ';
				list += '<button class="btn btn-xs btn-danger" id="del'+hotel.id+'">видалити</button> ';
				list += '<button class="btn btn-xs btn-success">продовжити</button> ';
				list += '<button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" id="edit'+hotel.id+'">';
				list += 'редагувати</button> ';
				list += '<a class="btn btn-xs btn-info" href="hotel/'+hotel.id+'">переглянути</a> ';
				list += '<button class="btn btn-xs btn-success">VIP</button> ';
				list += '<button class="btn btn-xs btn-success">TOP</button> ';
				list += '<button class="btn btn-xs btn-success">Зробити платним</button> ';
				list += '<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#roomsModal" id="rooms'+hotel.id+'">';
				list += 'кімнати</button></td></tr>';
            }
			$('#add_list tbody').html(list);
			add_click();
		}
	})
}

function add_click(){
    // кнопка редактировать отель
	$('#add_list button[id^="edit"]').each(function(){// tested
		$(this).click(function(){
			var id=$(this).attr('id').substr(4);
			adInfo(id);
		});
	});

    // просмотр списка комнат отеля
	$('#add_list button[id^="rooms"]').each(function(){// tested
		$(this).click(function(){
			var id=$(this).attr('id').substr(5);
			rooms(id);
		});
	});

    // удаление отеля
	$('#add_list button[id^="del"]').each(function(){// tested
		$(this).click(function(){
			var id=$(this).attr('id').substr(3);
            $.ajax({
                url: baseUrl+'hotel/'+id,
                type:'DELETE',
                success: function(data){
                    setAlert('Видалення', 'оголошення № '+id+' видалене', 'alert-success');
                    adds_filter();
                }
            });
			return false;
		});
	});
}

function room_click(){// tested
	$('#rooms_list button[id^="room_e"]').each(function(){
		$(this).click(function(){
			var id=$(this).attr('id').substr(6);
            $.ajax({
                url: baseUrl+'admin/roominfo/'+id,
                type:'GET',
                success: function(data){
                    if (!data){
                        setAlert('Помилка', 'Некоректний id номера', 'alert-danger');
                    } else {
                        var room = JSON.parse(data);
                        $('#edit_room_id').val(room.id);
                        $('#r_price').val(room.price);
                        $('#r_name').val(room.title);
                        $('#r_about').val(room.about);
                        if (room.price_type == 0){
                            $('#rprice0').prop('checked', 'checked');
                            $('#rprice1').removeAttr('checked');
                        } else {
                            $('#rprice1').prop('checked', 'checked');
                            $('#rprice0').removeAttr('checked');
                        }
                        $('#e_beds').val(room.beds);
                        if (room.wc == 1){
                            $('#wc0').prop('checked', 'checked');
                            $('#wc1').removeAttr('checked');
                        } else {
                            $('#wc1').prop('checked', 'checked');
                            $('#wc0').removeAttr('checked');
                        }
                        if (room.bath == 1){
                            $('#rbath0').prop('checked', 'checked');
                            $('#rbath1').removeAttr('checked');
                        } else {
                            $('#rbath1').prop('checked', 'checked');
                            $('#rbath0').removeAttr('checked');
                        }
                        if (room.tv == 1){
                            $('#tv0').prop('checked', 'checked');
                            $('#tv1').removeAttr('checked');
                        } else {
                            $('#tv1').prop('checked', 'checked');
                            $('#tv0').removeAttr('checked');
                        }
                        if (room.cond == 1){
                            $('#cond0').prop('checked', 'checked');
                            $('#cond1').removeAttr('checked');
                        } else {
                            $('#cond1').prop('checked', 'checked');
                            $('#cond0').removeAttr('checked');
                        }
                        if (room.holo == 1){
                            $('#holo0').prop('checked', 'checked');
                            $('#holo1').removeAttr('checked');
                        } else {
                            $('#holo1').prop('checked', 'checked');
                            $('#holo0').removeAttr('checked');
                        }
                        if (room.kitchen == 1){
                            $('#rkitchen0').prop('checked', 'checked');
                            $('#rkitchen1').removeAttr('checked');
                        } else {
                            $('#rkitchen1').prop('checked', 'checked');
                            $('#rkitchen0').removeAttr('checked');
                        }
                        if (room.wifi == 1){
                            $('#wifi0').prop('checked', 'checked');
                            $('#wifi1').removeAttr('checked');
                        } else {
                            $('#wifi1').prop('checked', 'checked');
                            $('#wifi0').removeAttr('checked');
                        }
                        $('#room_form').slideDown();
                    }
                }
            });
		});
	});

	$('#rooms_list button[id^="room_d"]').each(function(){//tested
		$(this).click(function(){
			var id=$(this).attr('id').substr(6);
            $.ajax({
        		url: baseUrl+'admin/room/'+id,
        		type:'DELETE',
        		success: function(data){
        			if (data == '0'){
                        rooms(hotel_id);
                        setAlert('Видалення', 'кімната № '+id+' видалена', 'alert-success');
                    } else{
                        setAlert('Помилка видаленя', data, 'alert-danger');
                    }
        		}
        	});
		});
	});

    $('#save_room_but').click(function(){
        var ver = verify([
            ['r_name','name'],
            ['r_about','text'],
            ['r_price','num'],
            ['e_beds','num'],
        ]);
        if (ver){
            var room = $('#room_form').serialize();
        	$.ajax({
        		url: baseUrl+'admin/saveRoom',
        		type:'POST',
        		data: room,
        		success: function(info){
                    console.log(info);
                    if (info == '0'){
                        adds_filter($('#filter').val());
                        setAlert('Збереження', 'номер № '+$('#edit_room_id').val()+' збережений', 'alert-success');
                    } else{
                        setAlert('Помилка збереження', info, 'alert-danger');
                    }
        		}
        	});
        }
        $('#room_form').slideUp();
        return false;
    });
}

add_click();

function adInfo(id){// tested
	$.ajax({
		url: baseUrl+'admin/hotelinfo',
		type:'POST',
		data:'hotel_id='+id,
		success: function(data){
			var add=JSON.parse(data);
			$('#edit_name').val(add.title);
			$('#edit_address').val(add.address);
			$('#edit_id').val(add.id);
			$('#edit_text').val(add.about);
			var date=new Date(add.created_at);
			$('#create_date').val(date.toISOString().substr(0,10));
            date=new Date(add.date_up);
			$('#date_up').val(date.toISOString().substr(0,10));
			date=new Date(add.date_out);
			$('#date_out').val(date.toISOString().substr(0,10));
			date=new Date(add.date_pay);
			$('#date_pay').val(date.toISOString().substr(0,10));
			date=new Date(add.date_top);
			$('#date_top').val(date.toISOString().substr(0,10));
			date=new Date(add.date_vip);
			$('#date_vip').val(date.toISOString().substr(0,10));
			$('#htype option').each(function(){
				if ($(this).val()==add.hotel_type_id) $(this).attr('selected','selected');
			});
			$('#city option').each(function(){
				if ($(this).val()==add.city_id) $(this).attr('selected','selected');
			});
            $('#e_rooms').val(add.rooms);
            $('#e_lux').val(add.lux);
            $('#e_to_beach').val(add.to_beach);
            $('#e_to_rest').val(add.to_rest);
            $('#e_to_disco').val(add.to_disco);
            $('#e_to_shop').val(add.to_shop);
            $('#e_to_bus').val(add.to_bus);
            if (add.bath == 0){
                $('#bath0').prop('checked', 'checked');
                $('#bath1').removeAttr('checked');
            } else {
                $('#bath1').prop('checked', 'checked');
                $('#bath0').removeAttr('checked');
            }
            if (add.parking == 1){
                $('#parking0').prop('checked', 'checked');
                $('#parking1').removeAttr('checked');
            } else {
                $('#parking1').prop('checked', 'checked');
                $('#parking0').removeAttr('checked');
            }
            if (add.altan == 1){
                $('#altan0').prop('checked', 'checked');
                $('#altan1').removeAttr('checked');
            } else {
                $('#altan1').prop('checked', 'checked');
                $('#altan0').removeAttr('checked');
            }
            if (add.kids == 1){
                $('#kids0').prop('checked', 'checked');
                $('#kids1').removeAttr('checked');
            } else {
                $('#kids1').prop('checked', 'checked');
                $('#kids0').removeAttr('checked');
            }
            if (add.kitchen == 1){
                $('#kitchen0').prop('checked', 'checked');
                $('#kitchen1').removeAttr('checked');
            } else {
                $('#kitchen1').prop('checked', 'checked');
                $('#kitchen0').removeAttr('checked');
            }
            $('#e_price').val(add.price);
            if (add.price_type == 0){
                $('#hprice0').prop('checked', 'checked');
                $('#hprice1').removeAttr('checked');
            } else {
                $('#hprice1').prop('checked', 'checked');
                $('#hprice0').removeAttr('checked');
            }
			//console.log(data);
		}
	})
}

function rooms(id){//tested
    hotel_id = id;
	$('#room_form').hide();
	$.ajax({
		url: baseUrl+'admin/roomsinfo',
		type:'POST',
		data:'id='+id,
		success: function(data){
            room = JSON.parse(data);
            var list = '';
            for(i=0; i<room.length; i++){
                list += '<tr class="ponter">';
                list +='<td class="hidden">'+room[i].id+'</td>';
                list +='<td>'+room[i].title+'</td>';
                list +='<td>'+room[i].beds+' сп.м.</td>';
                list +='<td>'+room[i].price+' грн.</td>';
                var url= '../room/'+room[i].id;
                list +='<td><a href="'+url+'" class="btn btn-info btn-xs">info</a</td>';
                list +='<td><button id="room_e'+room[i].id+'" class="btn btn-warning btn-xs">edit</button></td>';
                list +='<td><button id="room_d'+room[i].id+'" class="btn btn-danger btn-xs">del</button></td>';
                list +='</tr>';
            }
			$('#rooms_list tbody').html(list);
			room_click();
		}
	})
}


//сохранение отеля
$('#save_but').click(function(){// tested
    var ver = verify([
        ['edit_id','num'],
        ['edit_name','name'],
        ['htype','num'],
        ['city','num'],
        ['edit_address','text'],
        ['edit_text','text'],
        ['create_date','date'],
        ['date_out','date'],
        ['date_pay','date'],
        ['date_top','date'],
        ['date_vip','date'],
        ['date_up','date'],
        ['e_rooms','num'],
        ['e_to_beach','num'],
        ['e_to_disco','num'],
        ['e_to_bus','num'],
        ['e_to_rest','num'],
        ['e_to_shop','num'],
        ['e_price','num'],
    ]);
    if (ver){
        var form=$('#edit_form').serialize();
    	$.ajax({
    		url: baseUrl+'admin/saveHotel',
    		type:'POST',
    		data: form,
    		success: function(info){
                console.log(info);
                if (info == '0'){
                    adds_filter($('#filter').val());
                    setAlert('Збереження', 'оголошення № '+$('#edit_id').val()+' збережено', 'alert-success');
                } else{
                    setAlert('Помилка збереження', info, 'alert-danger');
                }
    		}
    	});
    } else{
        return false;
    }
});

$('#save_room').click(function(){
	var form=$('#room_form').serialize();
	$.ajax({
		url:'../rooms/'+$('#room_id'),
		type:'PUT',
		data:form,
		success: function(info){
			console.log(info);
			rooms($('#hotel_id').val());
			$('#room_form').show();
		}
	})

	return false;
});

})})(jQuery)
