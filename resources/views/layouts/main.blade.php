<!DOCTYPE html>
<html class="has-navbar-fixed-top">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ELR - Map your charge!</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-extensions@2.2.1/dist/css/bulma-extensions.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    @stack('styles')
  </head>
  <body>

    <nav class="navbar is-transparent is-fixed-top" id="navbar">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="{{ url('/') }}">
            <img src="{{ asset('img/logo_elr-01.png') }}" alt="ELR - Map your charge!" width="112" height="28">
          </a>
          <div class="navbar-burger burger" data-target="navbarT">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>

        <div id="navbarT" class="navbar-menu">
          <div class="navbar-start">
            <a class="navbar-item is-condensed is-black" href="{{ url('/') }}">
              <span class="icon">
                <i class="fas fa-location-arrow"></i>
              </span>
              Планирай пътуване
            </a>
            <a class="navbar-item is-condensed is-black" href="{{ url('/vehicles') }}">
              <span class="icon">
                <i class="fas fa-car"></i>
              </span>
              Превозни средства
            </a>
            <a class="navbar-item is-condensed is-black" href="{{ url('search') }}">
              <span class="icon">
                <i class="fas fa-history"></i>
              </span>
              Запазени търсения
            </a>
            <a class="navbar-item is-condensed is-black" href="{{ url('plans') }}">
              <span class="icon">
                <i class="fas fa-calendar-alt"></i>
              </span>
              Планирани пътувания
            </a>
          </div>

          <div class="navbar-end">
            @if (Auth::user())
            <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link is-condensed is-black" href="">
                <span class="icon">
                  <i class="far fa-user"></i>
                </span>
                Здравей, Константин!
              </a>
              <div class="navbar-dropdown is-boxed">
                <a class="navbar-item" href="{{ url('activity') }}">
                  История на действията
                </a>
                <hr class="navbar-divider">
                <a class="navbar-item" href="{{ url('profile') }}">
                  Настройки
                </a>
                <form action="{{ url('logout') }}" method="post" class="navbar-item">
                  @csrf

                  <button type="submit" class="button is-error is-block is-condensed is-black" style="width: 100%;">Изход</button>
                </form>
              </div>
            </div>
            @else
            <div class="navbar-item">
              <div class="field is-grouped">
                <p class="control">
                  <a class="button is-light" href="{{ url('login') }}">
                    <span class="icon">
                      <i class="far fa-user"></i>
                    </span>
                    <span class="">Вход</span>
                  </a>
                </p>
                <p class="control">
                  <a class="button is-success" href="{{ url('register') }}">
                    <span class="">Регистрация</span>
                  </a>
                </p>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </nav>
    @yield('anatomy')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-shim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-sham.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-shim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-sham.min.js"></script>
    {{-- <script src="https://wzrd.in/standalone/es7-shim@latest"></script> --}}
    <script src="https://unpkg.com/vue"></script>
    <script src="https://unpkg.com/vuex"></script>
    <script src="https://unpkg.com/lodash"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"></script>
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="https://unpkg.com/element-ui/lib/umd/locale/bg.js"></script>
    <script>
    ELEMENT.locale(ELEMENT.lang.bg);
    </script>

    @stack('scripts')
  </body>
</html>