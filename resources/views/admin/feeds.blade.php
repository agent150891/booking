@extends('layouts.admin')

@section('content')

<h1 class="h3">Відгуки</h1>
<table class="table table-striped" id="add_list">
	<tbody id="list">

        @foreach ($feeds['list'] as $feed)
				<tr>
					<td class="id">{{$feed->id}} </td>
                    <td>{{$feed->title}}<br>{{$feed->owner_name}} {{$feed->phone}}</td>
                    <td>{{$feed->author_name}}<br>{{$feed->author_phone}}</td>
                    <td  class="comment">
                        <p>
                    @if($feed->reight == 1)
                        <span class="plus"></span>
                    @elseif($feed->reight == -1)
                        <span class="minus"></span>
                    @else
                        <span class="re"></span>
                    @endif
                        {{$feed->comment}}
                        </p>
                    </td>
                    <td>
                    @if ($feed->status == 0)
                        блокований
                    @endif
                    @if ($feed->status == 1)
                        підтверджен
                    @endif
                    @if ($feed->status == 2)
                        переглянутий
                    @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success sf">дозволити</button>
                        <button class="btn btn-sm btn-warning bf">блокувати</button>
                        <button class="btn btn-sm btn-danger df">видалити</button>
                    </td>
				</tr>
		@endforeach
	</tbody>
	<thead>
		<tr>
			<th>id</th>
			<th>Назва/Власник</th>
			<th>Автор відгуку</th>
			<th>Відгук</th>
            <th>Статус</th>
			<th>Дії</th>
		</tr>
	</thead>
</table>
<div class="text-center" id="pagg_block">
    @php
        echo $feeds['pagg'];
    @endphp
</div>
<form class="form-inline text-center">
	<input type="text" class="form-control" id='filter'>
	<input type="submit" value="найти" class="form-control" id="find">
</form>

<script>
var baseUrl='../';
</script>
<script src="{{ url('js/admin/admin_feeds.js')}}"></script>
@endsection
