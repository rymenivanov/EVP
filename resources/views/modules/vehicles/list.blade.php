@extends('layouts.main')

@section('anatomy')
<div class="container">
	<div class="columns">
		<div class="column" style="margin-top: 50px;" id="instance">
			<h2 class="is-size-3 is-condensed is-black is-pulled-left">Вашите превозни средства</h2>
			<a href="#" @click.prevent="instance.isVisible = true;" class="button is-success is-pulled-right">Добави ново превозно средство</a>
			<div class="is-clearfix"></div>
            <hr style="margin: 5px 0px">
			<table class="table" style="width: 100%;">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Регистрационен номер</th>
			      <th>Производител</th>
			      <th>Модел</th>
			      <th>Време за зареждане</th>
			      <th>Разстояние</th>
			      <th>Максимална скорост</th>
			      <th class="has-text-right">Настройки</th>
			    </tr>
			  </thead>
			  <tfoot>
			    <tr>
			      <th>#</th>
			      <th>Регистрационен номер</th>
			      <th>Производител</th>
			      <th>Модел</th>
			      <th>Време за зареждане</th>
			      <th>Разстояние</th>
			      <th>Максимална скорост</th>
			      <th class="has-text-right">Настройки</th>
			    </tr>
			  </tfoot>
			  <tbody>
			  	@foreach ($els as $index => $el)
			    <tr>
			      <td>{{ $index + 1 }}</td>
			      <td>{{ $el->id_number }}</td>
			      <td>{{ $el->make->manufacturer->title }}</td>
			      <td>{{ $el->make->title }}</td>
			      <td>{{ $el->make->specification->chargeTime }} минути</td>
			      <td>{{ $el->make->specification->distance }} км.</td>
			      <td>{{ $el->make->specification->maxSpeed }} км/ч</td>
			      <td class="has-text-right">
			      	<form action="{{ url('vehicles/' . $el->hash) }}" method="post">
			      		@csrf
			      		{{ method_field('DELETE') }}

			      		<button type="submit" class="button is-danger">Изтрий превозното средство</button>
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

<div class="modal" :class="{ 'is-active' : isVisible }" id="vehicle">
  <div class="modal-background"></div>
  <div class="modal-card">
    <section class="modal-card-body">
      <div class="columns">
        <div class="column">
          <h1 class="is-size-3">Добави ново превозно средство</h1>
          <hr style="margin-top: 5px;">
        </div>
      </div>

      <div class="columns">
        <div class="column has-text-centered">
          <img src="{{ asset('img/car.png') }}" style="margin-top: -150px;" alt="">
          <div class="is-divider" data-content="Детайли" style="margin-top: -100px;"></div>

          <form action="{{ url('vehicles') }}" method="post" id="vehicle" class="has-text-left" ref="form" @submit.prevent="onSubmit()">
            @csrf
            <div class="columns">
              <div class="column">
                <div class="field">
                  <label class="is-condensed is-black">Производител</label>
                  <el-select name="manufacturer" v-model="manufacturer" placeholder="Моля, изберете от списъка" style="width: 100%">
                    <el-option
                      v-for="item in manufacturers"
                      :key="item.hash"
                      :label="item.title"
                      :value="item.hash">
                    </el-option>
                  </el-select>
                </div>
              </div>

              <div class="column">
                <div class="field">
                  <label class="is-condensed is-black">Модел</label>
                  <el-select name="make" v-model="make" placeholder="Моля, изберете от списъка" style="width: 100%">
                    <el-option
                      v-for="item in makes"
                      :key="item.hash"
                      :label="item.title"
                      :value="item.hash">
                    </el-option>
                  </el-select>
                </div>
              </div>

              <div class="column">
                <div class="field">
                  <label class="is-condensed is-black">Регистрационен номер</label>
                  <el-input name="id_number" placeholder="Регистрационен номер" v-model="idNumber"></el-input>
                </div>
              </div>
            </div>

            <a href="#" class="button is-success is-block is-condensed is-black" @click.prevent="onSubmit()">Добави превозното средство</a>
          </form>
        </div>
      </div>
    </section>
  </div>
  <button class="modal-close is-large" aria-label="close" @click.prevent="isVisible = false;"></button>
</div>
@endsection

@push('scripts')
<script>
var vm = new Vue({
	el: '#vehicle',

	data: {
		manufacturer: null,
		manufacturers: {!! $manufacturers->toJSON() !!},
		makes: [],
		make: '',
		details: null,
		idNumber: '',
		isVisible: false
	},

	watch: {
		manufacturer: function (value) {
			this.getMakes();
		},

		make: function (value) {
			this.getDetails();
		}
	},

	methods: {
		getMakes: function () {
			let app = this;

			axios.get('{{ url('api/v1/manufacturers/') }}/' + this.manufacturer + '/makes')
				 .then(function (response) {
				 	app.makes = response.data;
				 })
				 .catch(function (errors) { console.log(errors); });
		},

		getDetails: function () {
			let app = this;

			axios.get('{{ url('api/v1/makes/') }}/' + this.make)
				 .then(function (response) {
				 	app.details = response.data;
				 })
				 .catch(function (errors) { console.log(errors); });
		},

		onSubmit: function () {
			if (this.manufacturer != null && this.make != null && this.idNumber.length == 8) {
				let app = this;

				axios.post('{{ url('vehicles') }}', {manufacturer: this.manufacturer, make: this.make, idNumber: this.idNumber})
					 .then(function (response) {
					 	if (response.data.isSuccess) {
					 		location.href = "{{ url('vehicles') }}";
					 	}
					 	else
					 	{
					 		app.$message({
			                  message: 'Възникна грешка при запаметяването на превозното средство.',
			                  type: 'error'
			                });
					 	}
					 })
					 .catch(function (errors) { console.log(errors); });
			}
		}
	}
});

new Vue({
	el: '#instance',

	data: {
		instance: vm
	}
});
</script>
@endpush