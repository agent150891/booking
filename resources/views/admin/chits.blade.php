@extends('layouts.app')

@section('content')
<h1 class="h1 text-success">Администрирование отзывов</h1>
<ul class="breadcrumb">
  <li><a href="{{url('/home')}}">Главная</a></li>
  <li><a href="{{url('/admin')}}">Администрирование</a></li>
  <li class="active">Управление отзывами</li>
</ul>
<div class="row">
	<div class="col-md-2">
	<!-- фильтр -->
		<form id="chit_filter">
			<div class="form-group">
				<h5>статус</h5>
				<label>
					<input type="radio" checked name="status" value="all">
					Все
				</label><br>
				<label>
					<input type="radio" name="status" value="ON">
					ON
				</label><br>
				<label>
					<input type="radio" name="status" value="OFF">
					OFF
				</label><br>
				<label>
					<input type="radio" name="status" value="PRE">
					PRE
				</label>
			</div>
			<div class="form-group">
				<h5>раздел</h5>
				<label>
					<input type="radio" checked name="type" value="all">
					Все
				</label><br>
				<label>
					<input type="radio" name="type" value="hotels">
					сдача жилья
				</label><br>
				<label>
					<input type="radio" name="type" value="rooms">
					комнаты
				</label><br>
				<label>
					<input type="radio" name="type" value="other">
					остальные
				</label>
			</div>
			<input type="submit" value="ПОКАЗАТЬ" class="btn btn-default">
		</form>
	</div>
	<div class="col-md-7">
	<!-- отзывы -->
		<table class="table table-striped">
			<tbody id="chit_table">
				@foreach ($chits as $chit)
					<tr>
						<td class="hidden">{{$chit->id}}</td>
						<td>{{$chit->user()->value('name')}}</td>
						@if ($chit->table_name=='hotels')
							<td>Сдача жилья</td>
						@endif
						<td>{{$chit->name}}</td>
						@if ($chit->weight==1)
							<td>хороший</td>
						@else
							<td>плохой</td>
						@endif
						<td>{{$chit->status()->value('status')}}</td>
						<td>{{$chit->created_at}}</td>
					</tr>
				@endforeach
			</tbody>
			<thead>
				<tr>
					<th>Пользователь</th>
					<th>Раздел</th>
					<th>Объявление</th>
					<th>Отзыв</th>
					<th>Статус</th>
					<th>Дата</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="col-md-3">
		<form action="" id="chit_edit">
			<h4>Объявление: <span id="thema"></span> </h4>
			<p>Создал: <span id="owner_name"></span></p>
			<p>Тел: <span id="owner_tel"></span></p>
			<h4>Автор комментария: <span id="author_name"></span></h4>
			<p>Тел: <span id="author_tel"></span></p>
			<p class="well" id="comment"></p>
			<input type="hidden" name="id" id="id">
			<input type="hidden" name="status" id="status">
			<input type="submit" id="ON" value="ON" class="btn btn-success">
			<input type="submit" id="OFF" value="OFF" class="btn btn-danger">
		</form>
	</div>
</div>
<script src="{{ url('js/admin_chits.js')}}"></script>
@endsection
