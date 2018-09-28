@extends('layouts.app')

@section('content')
<h1 class="h1 text-success">Администрирование объявления</h1>
<ul class="breadcrumb">
  <li><a href="{{url('/home')}}">Главная</a></li>
  <li><a href="{{url('admin/index')}}">Администрирование</a></li>
  <li><a href="{{url('admin/hotels')}}">объявления жильё</a></li>
  <li class="active">комнаты</li>
</ul>
<div class="row">
	
	<div class="col-md-3">
		<table id="ad_list" class="table table-striped">
			@foreach ($rooms as $room)
				<tr class="pointer">
					<td class="hidden">{{$room->id}}</td>
					<td>{{$room->name}}</td>
					<td>{{$room->status()->value('status')}}</td>
				</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-3">
		<div id="ad_info">
			<h4 id="room_name">Название: <span></span></h3>
			<p id="room_places">Мест: <span></span></p>
			<p id="room_price">Цена: <span></span> грн.</p>
			<p id="room_date">Добавлено: <span></span></p>
		</div>
	</div>
	<div class="col-md-2">
		<form id="ad_edit">
			<select name="status" id="status" class="form-control">
				<option value="0">Выберите статус</option>
				@foreach ($statuses as $status)
					<option value="{{$status->id}}">{{$status->status}}</option>
				@endforeach
			</select>
			<input type="text" name="comment" id="comment" class="form-control" placeholder="комментарий...">
			<input type="hidden" name="room_id" id="room_id">
			<input type="submit" name="set_but" id="set_but" class="btn btn-warning form-control" value="изменить статус">
		</form>
	</div>
	<div class="col-md-2">
		<nav class="btn-group-vertical">
			
		</nav>
	</div>
</div>


<script src="{{ url('js/admin_rooms.js')}}"></script>
@endsection