<!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="{{ url('home') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">{{ config('app.name') }}</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">{{ config('app.name') }}</span>
        </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account Menu -->
              
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  @if(Auth::user()->profile_picture != NULL)
                    <?php $user_profile = \Auth::user()->profile_picture; ?>
                    {!! Html::image('img/user/thumb_'.$user_profile, 'User Image', ['class'=>'user-image']) !!}
                  @else
                    {!! Html::image('img/admin-lte/user2-160x160.jpg', 'User Image', ['class'=>'user-image']) !!}
                  @endif
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    @if(Auth::user()->profile_picture != NULL)
                      <?php $user_profile = \Auth::user()->profile_picture; ?>
                      {!! Html::image('img/user/thumb_'.$user_profile, 'User Image', ['class'=>'img-circle']) !!}
                    @else
                      {!! Html::image('img/admin-lte/user2-160x160.jpg', 'User Image', ['class'=>'img-circle']) !!}
                    @endif
                    <p>
                      {{ Auth::user()->name }}
                      <small>{{ \Auth::user()->roles()->first()->name }}</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ url('my-profile') }}" class="btn btn-default btn-flat">My Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>