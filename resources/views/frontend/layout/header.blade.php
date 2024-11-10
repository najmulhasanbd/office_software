<header>
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="{{route('user.dashboard')}}">
                <img src="{{ asset('frontend/logo.jpg') }}" style="width: 200px" alt="logo">
            </a>
        </div>

        <div class="d-flex align-items-center gap-2" style="position: relative">
            <div id="current-time"></div>

         
            <div class="d-flex align-items-center">
                <img src="{{ asset('frontend/user.png') }}" alt="">
                {{-- <ul class="dropdown-menus" id="dropdownMenu">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="btn btn-default btn-flat"> {{ __('Log Out') }}</a>
                    </form>
                </ul> --}}

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ ucwords(Auth::user()->name) }}
                    </button>
                    <ul class="dropdown-menu">
                      <li><button class="dropdown-item" type="button"><a href="{{route('sales.report')}}">My Report</a></button></li>
                      <li><button class="dropdown-item" type="button"><a href="{{route('sales.list')}}">Sales List</a></button></li>
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="btn btn-default btn-flat"> {{ __('Log Out') }}</a>
                    </form>
                    </ul>
                  </div>
            </div>
        </div>
    </div>
</header>
