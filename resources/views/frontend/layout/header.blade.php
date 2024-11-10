<header>
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="">
                <img src="{{ asset('frontend/logo.jpg') }}" style="width: 200px" alt="logo">
            </a>
        </div>

        <div class="d-flex align-items-center gap-2" style="position: relative">
            <div id="current-time"></div>

            <div class="d-flex align-items-center">
                <img src="{{ asset('frontend/user.png') }}" alt="">
                <h5 class="dropdown-toggle" id="userDropdown">{{ ucwords(Auth::user()->name) }}</h5>
                <ul class="dropdown-menus" id="dropdownMenu">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="btn btn-default btn-flat"> {{ __('Log Out') }}</a>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</header>
