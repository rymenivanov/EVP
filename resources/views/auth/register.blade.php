@extends('layouts.main')

@section('anatomy')
<div class="container">
    <div class="columns">
        <div class="column is-4"></div>
        <div class="column is-4" style="margin-top: 150px;">
            <h2 class="is-size-3 is-condensed is-black">Регистрация в платформата</h2>
            <hr style="margin: 5px 0px">
            <form action="{{ url('register') }}" method="post">
                @csrf

                <div class="field">
                  <div class="control">
                    <label for="">Име</label>
                    <input class="input" name="name" type="text" placeholder="Вашите имена" required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <label for="">Електронна поща</label>
                    <input class="input" name="email" type="text" placeholder="me@fundamental.bg" required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <label for="">Парола</label>
                    <input class="input" type="password" name="password" required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <label for="">Повторете паролата</label>
                    <input class="input" type="password" name="password_confirmation" required>
                  </div>
                </div>

                <button type="submit" class="button is-success is-block is-condensed is-black" style="width: 100%;">Регистрирай ме</button>
            </form>
        </div>
    </div>
</div>
@endsection