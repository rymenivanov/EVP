@extends('layouts.main')

@section('anatomy')
<div class="container">
	<div class="columns">
		<div class="column" style="margin-top: 50px;">
			<h2 class="is-size-3 is-condensed is-black">История на действията</h2>
            <hr style="margin: 5px 0px">
			<table class="table" style="width: 100%;">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Действие</th>
			      <th>Извършено на</th>
			    </tr>
			  </thead>
			  <tfoot>
			    <tr>
			      <th>#</th>
			      <th>Действие</th>
			      <th>Извършено на</th>
			    </tr>
			  </tfoot>
			  <tbody>
			  	@foreach ($els as $index => $el)
			    <tr>
			      <td>{{ $index + 1 }}</td>
			      <td>{{ $el->description }}</td>
			      <td>{{ $el->created_at->format('H:i часа на d.m.Y') }}</td>
			    </tr>
			    @endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection