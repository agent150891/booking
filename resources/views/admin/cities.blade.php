@extends('layouts.admin')

@section('content')
<h1 class="h3 text-success">Міста</h1>
	<div class="row">

	<div class="col-md-4">
		<table  class="table table-striped">
            <tbody id="list">
			@foreach ($cities as $city)
				<tr class="pointer">
					<td class="hidden">{{$city->id}}</td>
					<td class="city">{{$city->city}}</td>
                    <td class="alt">{{$city->gps_alt}}</td>
                    <td class="lng">{{$city->gps_lng}}</td>
				</tr>
			@endforeach
            <tbody>
		</table>
	</div>
    <div class="col-md-2">
        <form id="edit_city_form">
            <input type="text" id="e_city_name"  class="form-control" name="city" placeholder="Назва...">
            <input type="text" name="gps_alt" placeholder="altitude..." id="e_alt"  class="form-control">
            <input type="text" name="gps_lng" placeholder="longtitude..." id="e_lng"  class="form-control">
            <input type="hidden" id="e_city_id" value="0" name="id">
            <button class="btn btn-warning" id="e_city_but">Змінити</button>
        </form>
    </div>
	<div class="col-md-2">
		<nav class="btn-group-vertical">
			<form id="new_city_form">
				<input type="text" id="new_city_name"  class="form-control" name="city" placeholder="Назва...">
                <input type="text" name="gps_alt" placeholder="altitude..." id="new_alt"  class="form-control">
                <input type="text" name="gps_lng" placeholder="longtitude..." id="new_lng"  class="form-control">
		    	<button class="btn btn-success" id="add_city">Додати</button>
		    </form>
		</nav>
	</div>
</div>

<script>var baseUrl='../'</script>
<script src="{{ url('js/admin/admin_cities.js')}}"></script>
@endsection
