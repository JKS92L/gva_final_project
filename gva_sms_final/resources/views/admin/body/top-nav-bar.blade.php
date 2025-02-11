  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light ">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
          </li>

          {{-- <li class="nav-item d-none d-sm-inline-block">
              <a href="#" class="nav-link">Contact</a>
          </li> --}}
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">


          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-comments"></i>
                  <span class="badge badge-danger navbar-badge">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  Brad Diesel
                                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                              </h3>
                              <p class="text-sm">Call me whenever you can...</p>
                              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  John Pierce
                                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                              </h3>
                              <p class="text-sm">I got your message bro</p>
                              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  Nora Silvester
                                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                              </h3>
                              <p class="text-sm">The subject goes here</p>
                              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
          </li>

          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-warning navbar-badge">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-envelope mr-2"></i> 4 new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-users mr-2"></i> 8 friend requests
                      <span class="float-right text-muted text-sm">12 hours</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-file mr-2"></i> 3 new reports
                      <span class="float-right text-muted text-sm">2 days</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
          </li>

          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <!-- User Profile Picture -->
                  <img src="{{ asset('assets/images/gva_logo/grand view-PNG.png') }}" alt="User Image"
                      class="img-circle elevation-2" style="width: 30px; height: 30px;">
              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" style="min-width: 300px;">
                  <!-- Profile Card -->
                  <div class="card card-widget widget-user">
                      @if (Auth::check())
                          <!-- Background header with User Info -->
                          <div class="widget-user-header text-white"
                              style="background: url('{{ asset('assets/images/gva_env/IMG_5542.jpg') }}') center center;">

                              <h3 class="widget-user-username text-right">{{ Auth::user()->name }}</h3>
                              <h5 class="widget-user-desc text-right">{{ Auth::user()->email }}</h5>
                              <!-- Adjust role dynamically if needed -->
                          </div>
                          <!-- User Image -->
                          <div class="widget-user-image">
                              <img class="img-circle elevation-2"
                                  src="{{ asset('assets/images/gva_logo/grand view-PNG.png') }}" alt="User Avatar">
                          </div>
                          <!-- Card Footer with Stats -->
                          <div class="card-footer dropdown-footer text-center">
                              <!-- View Profile Button -->
                              <a href="{{ route('admin.view-profile') }}" class="btn btn-primary btn-sm btn-block">
                                  View Profile
                              </a>
                              <!-- Logout Button -->
                              <a href="{{ route('logout') }}" class="btn btn-danger btn-sm btn-block">
                                  Logout
                              </a>
                              <!-- Logout Form -->
                              <form id="logout-form" action="#" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </div>
                      @else
                          <!-- Display fallback content for unauthenticated users -->
                          <div class="widget-user-header text-center text-white bg-danger">
                              <h3 class="widget-user-username">Session Expired</h3>
                              <h5 class="widget-user-desc">Please <a href="{{ route('login') }}"
                                      class="text-white">log in</a></h5>
                          </div>
                      @endif
                  </div>
              </div>


          </li>




      </ul>
  </nav>
  <!-- /.navbar -->
