<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @php
                  use Illuminate\Support\Facades\Auth;
              @endphp
              <span class="hidden-xs" style="font-weight: 700">{{ ucwords(Auth::user()->name) }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-footer">
                <div class="pull-right">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                  <a href="route('logout')"
                  onclick="event.preventDefault();
                              this.closest('form').submit();" class="btn btn-default btn-flat"> {{ __('Log Out') }}</a>
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
