@extends('layouts.admin')

@section('content')

<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal hotel content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Редагування оголошення</h4>
      </div>
      <div class="modal-body">
        <form id="edit_form">
        	<input type="hidden" id="edit_id" name="edit_id">
        	<label class="form-inline">Назва <input type="text" class="form-control" id="edit_name" name="tittle"></label>
        	<select name="htype" id="htype" class="form-control">
				<option value="0">Оберіть тип житла</option>
				@foreach ($hotel_types as $type)
					<option value="{{$type->id}}">{{$type->hotel_type}}</option>
				@endforeach
			</select>
			<select name="city" id="city" class="form-control">
				<option value="0">Оберіть населений пункт</option>
				@foreach ($cities as $city)
					<option value="{{$city->id}}">{{$city->city}}</option>
				@endforeach
			</select>
			<input type="text" placeholder="адрес..." class="form-control" id="edit_address" name="address">
			<textarea class="form-control" rows="5" id="edit_text" name="text">
			</textarea>
            <div class="row">
                <div class="col-md-4">
		             <label for="create_date">Дата створення</label><input type="date" class="form-control" id="create_date" name="create_date">
                     <label for="date_up">Дата оновлення</label><input type="date" class="form-control" id="date_up" name="date_up">
		             <label for="date_out">Дата закінчення</label><input type="date" class="form-control" id="date_out" name="date_out">
			         <label for="date_pay">Дата платного</label><input type="date" class="form-control" id="date_pay" name="date_pay">
			         <label for="date_top">Дата ТОП</label><input type="date" class="form-control" id="date_top" name="date_top">
			         <label for="date_vip">Дата VIP</label><input type="date" class="form-control" id="date_vip" name="date_vip">
                </div>
                <div class="col-md-3">
                    <label>Всього кімнат<input type="number" class="form-control" id="e_rooms" name="rooms"></label>
                    <label>Кімнат класу Люкс<input type="number" class="form-control" id="e_lux" name="lux"></label>
                    <label>До пляжу<input type="number" class="form-control" id="e_to_beach" name="to_beach"></label>
                    <label>До магазину<input type="number" class="form-control" id="e_to_shop" name="to_shop"></label>
                    <label>До ресторану<input type="number" class="form-control" id="e_to_rest" name="to_rest"></label>
                    <label>До дискотеки<input type="number" class="form-control" id="e_to_disco" name="to_disco"></label>
                    <label>До зупинки<input type="number" class="form-control" id="e_to_bus" name="to_bus"></label>
                </div>
                <div class="col-md-5">
                    <h5>Туалет/душ:</h5>
                    <label class="radio-inline"><input type="radio" name="bath" id="bath0" value=0>Загальний</label>
                    <label class="radio-inline"><input type="radio" name="bath" id="bath1" value=1>У номері</label>
                    <h5>Паркінг:</h5>
                    <label class="radio-inline"><input type="radio" name="parking" id="parking0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="parking" id="parking1" value=0>Ні</label>
                    <h5>Альтанка</h5>
                    <label class="radio-inline"><input type="radio" name="altan" id="altan0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="altan" id="altan1" value=0>Ні</label>
                    <h5>Дитячий майданчик</h5>
                    <label class="radio-inline"><input type="radio" name="kids" id="kids0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="kids" id="kids1" value=0>Ні</label>
                    <h5>Кухня:</h5>
                    <label class="radio-inline"><input type="radio" name="kitchen" id="kitchen0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="kitchen" id="kitchen1" value=0>Ні</label>
                    <label>Ціна від <input type="number" class="form-control" id="e_price" name="price"></label>
                    <label class="radio-inline"><input type="radio" name="price_type" id="hprice0" value=0>За номер</label>
                    <label class="radio-inline"><input type="radio" name="price_type" id="hprice1" value=1>За ліжко</label>
                </div>
            </div>

        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success" id="save_but"  data-dismiss="modal">Зберегти</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
      </div>
    </div>

  </div>
</div>


<!-- end modal edit hotel-->

<div id="roomsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal rooms list content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Кімнати</h4>
      </div>
      <div class="modal-body">
      	<form id="room_form">
            <input type="hidden" id="edit_room_id" name="id">

            <div class="row">
                <div class="col-md-6">
                    <label >Назва <input type="text" class="form-control" id="r_name" name="title"></label>
                	<textarea class="form-control" rows="5" id="r_about" name="about">
        			</textarea>
                    <label>Ціна<input type="number" class="form-control" id="r_price" name="price"></label>
                    <div class="form-group">
                        <label class="radio-inline"><input type="radio" name="price_type" id="rprice0" value=0>За номер</label>
                        <label class="radio-inline"><input type="radio" name="price_type" id="rprice1" value=1>За ліжко</label>
                    </div>
                    <label>Всього ліжок<input type="number" class="form-control" id="e_beds" name="beds"></label>
                    <button id="save_room_but" class="btn btn-success">Зберегти</button>
                </div>
                <div class="col-md-6">
                    <h5>Туалет:</h5>
                    <label class="radio-inline"><input type="radio" name="wc" id="wc0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="wc" id="wc1" value=0>Ні</label>
                    <h5>Душ:</h5>
                    <label class="radio-inline"><input type="radio" name="bath" id="rbath0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="bath" id="rbath1" value=0>Ні</label>
                    <h5>Телевізор:</h5>
                    <label class="radio-inline"><input type="radio" name="tv" id="tv0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="tv" id="tv1" value=0>Ні</label>
                    <h5>Кондіціонер:</h5>
                    <label class="radio-inline"><input type="radio" name="cond" id="cond0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="cond" id="cond1" value=0>Ні</label>
                    <h5>Холодильник:</h5>
                    <label class="radio-inline"><input type="radio" name="holo" id="holo0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="holo" id="holo1" value=0>Ні</label>
                    <h5>Кухня:</h5>
                    <label class="radio-inline"><input type="radio" name="kitchen" id="rkitchen0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="kitchen" id="rkitchen1" value=0>Ні</label>
                    <h5>Wi-fi:</h5>
                    <label class="radio-inline"><input type="radio" name="wifi" id="wifi0" value=1>Так</label>
                    <label class="radio-inline"><input type="radio" name="wifi" id="wifi1" value=0>Ні</label>
                </div>
            </div>

		</form>
	</div>
        <table class="table table-striped" id="rooms_list">
        	<tbody>

        	</tbody>
        </table>
      </div>
      <div class="modal-footer">

      </div>
    </div>

  </div>
</div>
<!-- end modal rooms -->


<h1 class="h3">Оголошення</h1>
<table class="table table-striped" id="add_list">
	<tbody>
		@foreach ($hotels as $hotel)
				<tr>
					<td>{{$hotel->id}} </td>
					<td>{{$hotel->title}} </td>
					<td>{{$hotel->phone}} </td>
					@if (strtotime($hotel->date_vip)>time())
						<td>платное</td>
					@else
						<td>бесплатное</td>
					@endif
					<td>
						<button class="btn btn-xs btn-success">підняти</button>
						<button class="btn btn-xs btn-danger" id="del{{$hotel->id}}">видалити</button>
						<button class="btn btn-xs btn-success">подовжити</button>
						<button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal" id="edit{{$hotel->id}}">
							редагувати
						</button>
						<a class="btn btn-xs btn-info" href="{{asset('hotel/'.$hotel->id)}}">переглянути</a>
						<button class="btn btn-xs btn-success">VIP</button>
						<button class="btn btn-xs btn-success">TOP</button>
						<button class="btn btn-xs btn-success">Зробити платним</button>
						<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#roomsModal" id="rooms{{$hotel->id}}">
							кімнати
						</button>
					</td>
				</tr>
			@endforeach
	</tbody>
	<thead>
		<tr>
			<th>№</th>
			<th>Назва</th>
			<th>Телефон</th>
			<th>Платне</th>
			<th>Дії</th>
		</tr>
	</thead>
</table>
<form class="form-inline text-center">
	<input type="text" class="form-control" id='filter'>
	<input type="submit" value="найти" class="form-control" id="find">
</form>

<script>
var baseUrl='../';
</script>
<script src="{{ url('js/admin/admin_ads.js')}}"></script>
@endsection
