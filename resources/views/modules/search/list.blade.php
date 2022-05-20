@extends('layouts.main')

@section('anatomy')
<div class="container">
	<div class="columns">
		<div class="column" style="margin-top: 50px;">
			<h2 class="is-size-3 is-condensed is-black">Запазени търсения</h2>
            <hr style="margin: 5px 0px">
			<table class="table" style="width: 100%;">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Начало</th>
			      <th>Дестинация</th>
			      <th>Брой спирки</th>
			      <th class="has-text-right">Настройки</th>
			    </tr>
			  </thead>
			  <tfoot>
			    <tr>
			      <th>#</th>
			      <th>Начало</th>
			      <th>Дестинация</th>
			      <th>Брой спирки</th>
			      <th class="has-text-right">Настройки</th>
			    </tr>
			  </tfoot>
			  <tbody>
			  	@foreach ($els as $index => $el)
			    @php $el->data = json_decode($el->data); @endphp
			    <tr>
			      <td>{{ $index + 1 }}</td>
			      <td>{{ $el->data->start->address->formatted_address }}</td>
			      <td>{{ $el->data->end->address->formatted_address }}</td>
			      <td>{{ collect($el->data->stops)->count() }}</td>
			      <td class="has-text-right">
			      	<form action="{{ url('search/' . $el->hash) }}" method="post">
			      		@csrf
			      		{{ method_field('DELETE') }}

			      		<button type="submit" class="button is-danger">Изтрий търсенето</button>
			      	</form>
			      </td>
			    </tr>
			    @endforeach
				</tbody>
			</table>

			{{-- {{ $els->links() }} --}}
		</div>
	</div>
</div>
@endsection