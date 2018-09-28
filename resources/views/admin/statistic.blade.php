@extends('layouts.admin')

@section('content')
<h1 class="h2 text-success">Статистика</h1>
<div class="row">
	<div class="col-md-3">
		<h3>ОБЪЯВЛЕНИЯ</h3>
		<p>Активные: {{$active}}</p>
		<p>Не активные: {{$passive}}</p>
		<p>Платные: {{$pay_adds}}</p>
		<p>Беслатные: {{$unpay_adds}}</p>
		<hr>
		<p>Отдых:{{$all_hotels}}</p>
		<p>Другие:</p>
		<br>
		<p>Всего объявлений: {{$all_adds}}</p>
	</div>
	<div class="col-md-3">
		<h3>ПОСЕЩАЕМОСТЬ</h3>
		<p>Всего просмотров: {{$all_visits}}</p>
		<p>За последние 24 часа: {{$visit24}}</p>
		<br>
		<p>Сейчас на сайте: {{$visit1}}</p>
	</div>
	<div class="col-md-3">
		<h3>ФИНАНСЫ</h3>
		<p>За сегодня: грн.</p>
		<p>За месяц: грн.</p>
		<br>
		<p>Всего заявок:</p>
		<p>Из них оплачено:</p>
		<br>
		<p>Общая прибыль</p>
	</div>
	<div class="col-md-3">
		<h3>СМС</h3>
		<p>Баланс смс: {{$sms_amount->GetCreditBalanceResult . PHP_EOL}}</p>
		<p>Отправлено: {{$sms_all}}</p>
		<p>Доставлено:</p>
		<p>Ошибка:</p>
	</div>
</div>
@endsection
