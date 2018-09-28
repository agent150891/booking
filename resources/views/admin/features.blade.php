@extends('layouts.admin')

@section('content')
<h1 class="h1 text-success">Настройка категорий</h1>

<div class="row">

	<div class="col-md-3">
		<table id="features_list" class="table table-striped">
		<tbody>
			@foreach ($features as $feature)
				<tr class="pointer">
					<td class="hidden">{{$feature->id}}</td>
					<td>{{$feature->type}}</td>
				</tr>
			@endforeach
		</tbody>
		</table>
	</div>
	<div class="col-md-2">
		<nav class="btn-group-vertical">
			<form action="">
				<input type="text" id="new_feach"  class="form-control">
				<input type="hidden" id="feach_id" value="0">
		    	<button class="btn btn-success" id="add_feach">Добавить</button>
		    	<button class="btn btn-danger" id="del_feach">Удалить</button>
		    </form>
		</nav>
	</div>
</div>


<script src="{{url('js/admin_features.js')}}"></script>
@endsection
