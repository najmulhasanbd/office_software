<header>
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="">
                <img src="{{ asset('frontend/logo.jpg') }}" style="width: 200px" alt="logo">
            </a>
        </div>
        <div class="account">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    @php
                        use Illuminate\Support\Facades\Auth;
                    @endphp
                    {{ ucwords(Auth::user()->name) }}
                </button>
                <ul class="dropdown-menu">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')"
                            onclick="event.preventDefault();
                              this.closest('form').submit();"
                            class="btn btn-default btn-flat"> {{ __('Log Out') }}</a>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</header>
