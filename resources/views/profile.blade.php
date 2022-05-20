@extends('layouts.main')

@section('anatomy')
<div class="container">
    <div class="columns">
        <div class="column is-4"></div>
        <div class="column is-4" style="margin-top: 150px;">
            <h2 class="is-size-3 is-condensed is-black">Промяна на профил</h2>
            <hr style="margin: 5px 0px">
            <form action="{{ url('profile/' . Auth::user()->hash) }}" method="post">
                @csrf
                {{ method_field('PATCH') }}

                <div class="field">
                  <div class="control">
                    <label for="">Име</label>
                    <input class="input" name="name" type="text" value="{{ Auth::user()->name }}" placeholder="Вашите имена" required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <label for="">Електронна поща</label>
                    <input class="input" name="email" type="text" value="{{ Auth::user()->email }}" required>
                  </div>
                </div>
{{--                 <div class="field">
                  <div class="control">
                    <label for="">Текуща парола</label>
                    <input class="input" type="password" name="current_password" required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <label for="">Нова парола</label>
                    <input class="input" type="password" name="password" required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <label for="">Повторете новата паролата</label>
                    <input class="input" type="password" name="password_confirmation" required>
                  </div>
                </div> --}}

                <button type="submit" class="button is-success is-block is-condensed is-black" style="width: 100%;">Промени данните</button>
            </form>
        </div>
    </div>
</div>
@endsection