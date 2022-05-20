@extends('layouts.main')

@push('styles')
<style>
label {
	display: block;
}

.is-car {
	height: 500px;
	margin-top: -170px;
}
</style>
@endpush

@section('anatomy')
<div class="container">
	<div class="columns">
		<div class="column">
			<h1 class="is-size-3">Добави ново превозно средство</h1>
			<hr>
		</div>
	</div>

	<div class="columns">
		<div class="column is-5">
			<form action="" method="" id="form">
				@csrf

				<div class="field">
					<label>Производител на превозното средство</label>
					<el-select v-model="manufacturer" placeholder="Моля, изберете от списъка" style="width: 100%;">
						<el-option
						  v-for="item in manufacturers"
						  :key="item.hash"
						  :label="item.title"
						  :value="item.hash">
						</el-option>
					</el-select>
				</div>

				<div class="field" v-if="manufacturer != null">
					<label>Модел на превозното средство</label>
					<el-select v-model="make" placeholder="Моля, изберете от списъка" style="width: 100%;">
						<el-option
						  v-for="item in makes"
						  :key="item.hash"
						  :label="item.title"
						  :value="item.hash">
						</el-option>
					</el-select>
				</div>
			</form>
		</div>
		<div class="is-divider-vertical" data-content="Детайли"></div>
		<div class="column has-text-centered">
			<img class="is-car" src="{{ asset('img/car.png') }}" alt="">
		</div>
	</div>
</div>

    <div class="modal is-active" id="vehicle">
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
      <button class="modal-close is-large" aria-label="close"></button>
    </div>
@endsection

@push('scripts')
<script>
new Vue({
	el: '#vehicle',

	data: {
		manufacturer: null,
		manufacturers: {!! $manufacturers->toJSON() !!},
		makes: [],
		make: '',
		details: null,
		idNumber: ''
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
</script>
@endpush