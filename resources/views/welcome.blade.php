@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/animate.css">
@endpush

@section('anatomy')
<section class="hero is-success is-fullheight" id="app" v-cloak>
  <div class="container is-fluid">
    <div class="is-card" :class="{ 'animated fadeOutLeft' : isOptions, 'animated fadeInLeft' : !isOptions }" style="z-index: 9999!important;">
      <a href="#" @click.prevent="isOptions = true;">
        <i class="fas fa-cog"></i>
      </a>
      @if (Auth::user())
      <div class="select is-pulled-left">
        <select name="vehicle" v-model="vehicleHash">
          <option value="">Моля, изберете от списъка</option>
          <option :value="v.hash" v-for="(v, vIndex) in vehicles">@{{ v.make.manufacturer.title }} @{{ v.make.title }} - #@{{ v.id_number }}</option>
        </select>
      </div>
      <div class="is-clearfix"></div>
      @else
      <i class="fas fa-frown" style="color: #333; font-size: 5em;"></i><br><br>
      <h4 class="is-size-5 is-condensed is-black is-dark">
        <span class="is-heading is-dark">Моля, добавете превозно средство, за да използвате<br> пълната функционалност на платформата</span>
      </h4>
      @endif
      <div v-if="vehicle">
      <img src="{{ asset('img/car.png') }}" class="vehicle-img" alt="">
      <h4 class="is-size-5 is-condensed is-black" style="color: #000; margin-top: -85px;">@{{ vehicle.make.manufacturer.title }} @{{ vehicle.make.title }}</h4>
      <div class="columns has-text-centered m-t-10">
        <div class="column">
          <h4 class="is-size-5 is-condensed is-black is-dark">
            <span class="is-heading">Пробег</span>
            @{{ vehicle.make.specification.distance }} км.
          </h4>
        </div>
        <div class="column">
          <h4 class="is-size-5 is-condensed is-black is-dark">
            <span class="is-heading">Скорост</span>
            @{{ vehicle.make.specification.maxSpeed }} км/ч
          </h4>
        </div>
        <div class="column">
          <h4 class="is-size-5 is-condensed is-black is-dark">
            <span class="is-heading">Зареждане за</span>
            @{{ vehicle.make.specification.chargeTime }} м.
          </h4>
        </div>
      </div>
      </div>
      <div class="is-divider m-t-25" data-content="Данни за пътуването"></div>
      <div class="field" style="position: relative;">
        <autocomplete-input v-model="start.address"></autocomplete-input>
        {{-- <a href="#" @click.prevent="getMyLocation()"> --}}
          {{-- <i class="fas fa-location-arrow"></i> --}}
        {{-- </a> --}}
      </div>
      <div class="field is-relative" v-for="(stop, stopIndex) in stops">
        <autocomplete-input v-model="stop.address"></autocomplete-input>
        <a href="#" @click.prevent="removeStop(stopIndex)" style="position: absolute; top: 7px; right: 13px;"><i class="fas fa-times is-dark"></i></a>
      </div>
      <div class="field">
        <autocomplete-input v-model="end.address"></autocomplete-input>
      </div>
      <div class="columns">
        <div class="column">
          <a href="#" class="button is-primary is-block is-condensed is-black" @click.prevent="addStop()">Добави спирка</a>
        </div>
        <div class="column">
          <a href="#" class="button is-success is-block is-condensed is-black" @click.prevent="calculateRoute()">Изчисли</a>
        </div>
      </div>
      <div class="columns">
        <div class="column">
          <div class="is-divider m-t-10 m-b-0" data-content="Резултати"></div>
        </div>
      </div>
      <div class="columns has-text-centered">
        <div class="column">
          <h4 class="is-size-5 is-condensed is-black is-dark">
            <span class="is-heading">Дестинация</span>
            <span v-if="distance != null">@{{ distance.rows[0].elements[0].distance.text }}</span><span v-else>-</span>
          </h4>
        </div>
        <div class="column">
          <h4 class="is-size-5 is-condensed is-black is-dark">
            <span class="is-heading">Продължителност</span>
            <span v-if="distance != null">@{{ distance.rows[0].elements[0].duration.text }}</span><span v-else>-</span>
          </h4>
        </div>
      </div>
      <div class="columns has-text-centered">
        <div class="column">
          <h4 class="is-size-5 is-condensed is-black is-dark">
            <span class="is-heading">Зареждания</span>
            @{{ this.numberOfCharges }} спирки
          </h4>
        </div>
        <div class="column">
          <h4 class="is-size-5 is-condensed is-black is-dark">
            <span class="is-heading">Общ престой</span>
            @{{ this.numberOfCharges * 2 }} часа
          </h4>
        </div>
      </div>
      <div class="columns">
        <div class="column">
          <a href="#" class="button is-primary is-block is-condensed is-black" @click.prevent="saveSearch()">Запази търсенето</a>
        </div>
        <div class="column">
          <a href="#" class="button is-success is-block is-condensed is-black" @click.prevent="isPlan = true">Планирай пътуване</a>
        </div>
      </div>
    </div>
    <div class="is-card has-text-left" :class="{ 'animated fadeInLeft' : isOptions, 'animated fadeOutLeft' : !isOptions }" style="z-index: 6;">
      <a href="#" @click.prevent="isOptions = false;">
        <i class="fas fa-times is-close"></i>
      </a>
      <div>
        <h4 class="is-size-5 is-condensed is-black is-dark">
          <span class="is-heading">Избягвай пътища с фериботи</span>
        </h4>
        <div class="control">
          <label class="radio is-condensed is-black is-dark">
            <input type="radio" name="avoid_ferries" :value="true" v-model="routeOptions.avoidFerries">
            Да
          </label>
          <label class="radio is-condensed is-black is-dark">
            <input type="radio" name="avoid_ferries" :value="false" v-model="routeOptions.avoidFerries">
            Не
          </label>
        </div>
      </div>
      <div class="m-t-10">
        <h4 class="is-size-5 is-condensed is-black is-dark">
          <span class="is-heading">Избягвай магистрали</span>
        </h4>
        <div class="control">
          <label class="radio is-condensed is-black is-dark">
            <input type="radio" name="avoid_highways" :value="true" v-model="routeOptions.avoidHighways">
            Да
          </label>
          <label class="radio is-condensed is-black is-dark">
            <input type="radio" name="avoid_highways" :value="false" v-model="routeOptions.avoidHighways">
            Не
          </label>
        </div>
      </div>
      <div class="m-t-10">
        <h4 class="is-size-5 is-condensed is-black is-dark">
          <span class="is-heading">Избягвай пътища с пътни такси</span>
        </h4>
        <div class="control">
          <label class="radio is-condensed is-black is-dark">
            <input type="radio" name="avoid_tolls" :value="true" v-model="routeOptions.avoidTolls">
            Да
          </label>
          <label class="radio is-condensed is-black is-dark">
            <input type="radio" name="avoid_tolls" :value="false" v-model="routeOptions.avoidTolls">
            Не
          </label>
        </div>
      </div>
      <div class="m-t-10">
        <h4 class="is-size-5 is-condensed is-black is-dark">
          <span class="is-heading">Трафик и негово влияние</span>
        </h4>
        <div class="select">
          <select name="traffic_model" v-model="routeOptions.trafficModel">
            <option value="pessimistic">Песимистичен</option>
            <option value="optimistic">Оптимистичен</option>
            <option value="bestguess">Възможно най-точен</option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-body" id="hero-map"></div>
  <div class="modal" :class="{ 'is-active' : isPlan }">
    <div class="modal-background"></div>
    <div class="modal-card">
      <section class="modal-card-body">
        <h2 class="is-size-3 is-condensed is-black is-dark">Планиране на пътуване</h2>
        <hr style="margin: 10px 0px">
        <form action="#" method="post" @submit.prevent="planTrip()">
          <div class="field">
            <div class="control">
              <label class="is-condensed is-black is-block is-dark">Име на плана</label>
              <input type="text" class="input" name="title" v-model="plan.title" placeholder="Име на плана">
            </div>
          </div>
          <div class="field">
            <div class="control">
              <label class="is-condensed is-black is-block is-dark">Дата и час на плана</label>
              <el-date-picker style="width: 100%;" v-model="plan.dateTime" type="datetime" placeholder="Моля, изберете дата и час на тръгване" default-time="12:00:00"></el-date-picker>
            </div>
          </div>
          <button type="submit" class="button is-success is-block is-condensed is-black" style="width: 100%;">Планирай пътуването</button>
        </form>
      </section>
    </div>
    <button class="modal-close is-large" aria-label="close" @click.prevent="isPlan = false"></button>
  </div>
</section>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBER1RnUBImbkBSJ4goKXOYGUkD4vrg-5o&libraries=places&language=bg&v=3.31"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script>
  const addresses = {!! $addresses->toJSON() !!};
  @if (Auth::user())
  const vehicles = {!! Auth::user()->vehicles()->with('make.manufacturer', 'make')->get() !!};
  @else
  const vehicles = [];
  @endif
  const urls = {
    search: '{{ url('search') }}',
    plan: '{{ url('plan') }}'
  };
</script>
<script src="{{ asset('js/components.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endpush