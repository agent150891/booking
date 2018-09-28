@extends('layouts.admin')

@section('content')
<h1 class="h3">Платежи</h1>
<table class="table table-striped">
	<tbody>
		@foreach ($pays as $pay)
			<tr class="pointer">
				<td >{{$pay->id}}</td>
				<td>{{$pay->add()->value('name')}}</td>
				<td>{{$pay->user()->value('tel1')}}</td>
				<td>{{$pay->scheme()->value('name')}}</td>
				<td>{{$pay->created_at}}</td>
				<td>{{$pay->transaction}}</td>
				<td>
					@if ($pay->status()->value('status')=='ON')
						успешно
					@else
						неуспешно
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
	<thead>
		<tr>
			<th>№</th>
			<th>Название</th>
			<th>Телефон</th>
			<th>Оплачена услуга</th>
			<th>Дата оплаты</th>
			<th>ID платежа</th>
			<th>статус</th>
		</tr>
	</thead>
</table>
{{$pays->links()}}
<form class="form-inline text-center">
	<input type="text" class="form-control">
	<input type="submit" value="найти" class="form-control">
</form>
<script src="{{ url('js/admin_ads.js')}}"></script>
@endsection