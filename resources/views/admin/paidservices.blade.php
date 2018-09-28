@extends('layouts.admin')

@section('content')
<h1 class="h3 text-success">Налаштування платних послуг</h1>
<div class="row">
	<div class="col-md-3">
		<table id="list1" class="table table-striped paid_table">
      <tbody>
      @foreach ($paids as $p)
      @if ($p->type()->value('type')=="VIP")
        <tr class="pointer">
          <td class="hidden">{{$p->id}}</td>
          <td>{{$p->name}}</td>
          <td>{{$p->days}}</td>
          <td>{{$p->price}}</td>
        </tr>
      @endif
      @endforeach
      </tbody>
      <thead>
        <tr>
          <th>VIP</th>
          <th>днів</th>
          <th>грн.</th>
        </tr>
      </thead>
		</table>
	</div>

  <div class="col-md-3">
		<table id="list2" class="table table-striped paid_table">
      <tbody>
      @foreach ($paids as $p)
      @if ($p->type()->value('type')=="TOP")
        <tr class="pointer">
          <td class="hidden">{{$p->id}}</td>
          <td>{{$p->name}}</td>
          <td>{{$p->days}}</td>
          <td>{{$p->price}}</td>
        </tr>
      @endif
      @endforeach
      </tbody>
      <thead>
        <tr class="pointer">
          <th>TOP</th>
          <th>днів</th>
          <th>грн.</th>
        </tr>
      </thead>
		</table>
	</div>

  <div class="col-md-3">
    <table id="list3" class="table table-striped paid_table">
      <tbody>
      @foreach ($paids as $p)
      @if ($p->type()->value('type')=="Подовжити платне")
        <tr class="pointer">
          <td class="hidden">{{$p->id}}</td>
          <td>{{$p->name}}</td>
          <td>{{$p->days}}</td>
          <td>{{$p->price}}</td>
        </tr>
      @endif
      @endforeach
      </tbody>
      <thead>
        <tr class="pointer">
          <th>Подовжити платне</th>
          <th>днів</th>
          <th>грн.</th>
        </tr>
      </thead>
    </table>
  </div>

  <div class="col-md-3">
    <table id="list4" class="table table-striped paid_table">
      <tbody>
      @foreach ($paids as $p)
      @if ($p->type()->value('type')=="Подовжити безкоштовне")
        <tr class="pointer">
          <td class="hidden">{{$p->id}}</td>
          <td>{{$p->name}}</td>
          <td>{{$p->days}}</td>
          <td>{{$p->price}}</td>
        </tr>
      @endif
      @endforeach
      </tbody>
      <thead>
        <tr class="pointer">
          <th>Подовжити безкоштовне</th>
          <th>днів</th>
          <th>грн.</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<div class="row">
<form id="paid_form">
    <div class="col-md-1">

    </div>
    <div class="col-md-2">
      <label for="paid_type" class="form-control">Категория</label>
      <select class="form-control" name="paid_type" id='paid_type'>
        <option value="0">Выберите категорию</option>
        @foreach ($types as $t)
          <option value="{{$t->id}}">{{$t->type}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <label for="paid_name" class="form-control">Назва</label>
      <input type="text" name="paid_name" id="paid_name" class="form-control">
    </div>
    <div class="col-md-2">
      <label for="paid_days" class="form-control">Срок дій днів</label>
      <input type="text" name="paid_days" id="paid_days"  class="form-control">
    </div>
    <div class="col-md-2">
      <label for="paid_days" class="form-control">Вартість грн.</label>
      <input type="text" name="paid_price" id="paid_price"  class="form-control">
      <input type="hidden" name="paid_id" id="paid_id" value="0">
    </div>
    <div class="col-md-2">
        <button class="btn btn-success form-control" id="but_add">Додати</button>
        <button class="btn btn-warning form-control" id="but_edit">Змінити</button>
        <button class="btn btn-danger form-control" id="but_del">Видалити</button>
    </div>
</form>
</div>

<script>
    var baseUrl='../';
</script>
<script src="{{url('js/admin/admin_painservices.js')}}"></script>
@endsection
