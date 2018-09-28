@extends('layouts.admin')

@section('content')
<div class="row">

	<div class="col-md-3">
		<table id="ad_list" class="table table-striped">
			<caption>все объявления</caption>
			@foreach ($hotels as $hotel)
				<tr class="pointer">
					<td class="hidden">{{$hotel->id}}</td>
					<td>{{$hotel->name}}</td>
					<td>{{$hotel->status()->value('status')}}</td>
				</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-3">
		<div id="ad_info">
			<h4 id="hotel_name">Название: <span></span></h3>
			<p id="hotel_address">Адрес: <span></span></p>
			<p id="hotel_tobeach">До берега: <span></span> м</p>
			<p id="hotel_date">Добавлено: <span></span></p>
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
			<input type="hidden" name="hotel_id" id="hotel_id">
			<input type="submit" name="set_but" id="set_but" class="btn btn-warning form-control" value="изменить статус">
		</form>
		<form action="rooms" method="post" id="rooms">
			{{ csrf_field() }}
			<input type="hidden" name="h_id" id="h_id">
			<input type="submit" value="комнаты" class="btn btn-info form-control">
		</form>
	</div>
	<div class="col-md-2">
		<nav class="btn-group-vertical">

		</nav>
	</div>
</div>
<script>
var baseUrl='../';
</script>
<script src="{{ url('js/admin/admin_ads.js')}}"></script>
@endsection
