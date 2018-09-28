@extends('layouts.admin')

@section('content')
<h1 class="h1 text-success">Користувачі</h1>
<div class="row">

	<div class="col-md-3">
		<table id="user_list" class="table table-striped">
			@foreach ($users as $user)
				<tr class="pointer">
					<td class="hidden">{{$user->id}}</td>
					<td>{{$user->name}}</td>
					<td>{{$user->phone}}</td>
					<td>{{$user->email}}</td>
				</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-3">
		<div id="user_info">
            <input type="hidden" id="user_id">
			<h4>Им'я: <span id="user_name"></span></h4>
			<p id="user_phones">
            </p>
            <h5>Статус: <span id="user_role"></span></h5>
			<p>Доданий: <span id="user_date"></span></p>
		</div>
	</div>
	<div class="col-md-2">
		<form id="user_edit">
			<select name="status" id="status" class="form-control">
				<option value="-1">Оберіть статус</option>
					<option value="0">Блокований</option>
                    <option value="1">Користувач</option>
                    <option value="2">Адмін</option>
			</select>
			<input type="hidden" name="user_id" id="user_id">
			<input type="submit" name="set_but" id="set_but" class="btn btn-warning form-control" value="змінити статус">
		</form>
	</div>
	<div class="col-md-2">
		<nav class="btn-group-vertical">

		</nav>
	</div>
</div>

<script>var baseUrl='../'</script>
<script src="{{ url('js/admin/admin_users.js')}}"></script>
@endsection
