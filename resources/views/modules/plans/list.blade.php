@extends('layouts.main')

@section('anatomy')
<div class="container">
	<div class="columns">
		<div class="column" style="margin-top: 50px;">
			<h2 class="is-size-3 is-condensed is-black">Планирани пътувания</h2>
            <hr style="margin: 5px 0px">
			<table class="table" style="width: 100%;">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>План</th>
			      <th>Планирано за</th>
			      <th>Начало</th>
			      <th>Дестинация</th>
			      <th>Брой спирки</th>
			      <th class="has-text-right">Настройки</th>
			    </tr>
			  </thead>
			  <tfoot>
			    <tr>
			      <th>#</th>
			      <th>План</th>
			      <th>Планирано за</th>
			      <th>Начало</th>
			      <th>Дестинация</th>
			      <th>Брой спирки</th>
			      <th class="has-text-right">Настройки</th>
			    </tr>
			  </tfoot>
			  <tbody>
			  	@foreach ($els as $index => $el)
			    <tr>
			      <td>{{ $index + 1 }}</td>
			      <td>{{ $el->title }}</td>
			      <td>{{ $el->on->format('H:i часа на d.m.Y') }}</td>
			      <td>{{ $el->trip->start_point->address->formatted_address }}</td>
			      <td>{{ $el->trip->end_point->address->formatted_address }}</td>
			      <td>{{ collect($el->stops)->count() }}</td>
			      <td class="has-text-right">
			      	<form action="{{ url('plans/' . $el->hash) }}" method="post">
			      		@csrf
			      		{{ method_field('DELETE') }}

			      		<button type="submit" class="button is-danger">Изтрий плана</button>
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