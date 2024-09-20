  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="{{ asset('assets/images/gva_logo/grand view-PNG.png') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light text-wrap text-md">Grandview Academy- SMS</span>

      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Loop through each menu -->
                  @foreach ($menus as $menu)
                      <li class="nav-item {{ count($menu->submenus) > 0 ? 'has-treeview' : '' }}">
                          <a href="#" class="nav-link">
                              <i class="nav-icon {{ $menu->icon }}"></i>
                              <p>
                                  {{ $menu->menu_name }}
                                  @if (count($menu->submenus) > 0)
                                      <i class="right fas fa-angle-left"></i>
                                  @endif
                              </p>
                          </a>

                          <!-- Check if the menu has submenus -->
                          @if (count($menu->submenus) > 0)
                              <ul class="nav nav-treeview">
                                  <!-- Loop through submenus -->
                                  @foreach ($menu->submenus as $submenu)
                                      <li class="nav-item">
                                          <a href="#" class="nav-link">
                                              <i class="fa fa-angle-double-right"></i>
                                              <p>{{ $submenu->submenu_name }}</p>
                                          </a>
                                      </li>
                                  @endforeach
                              </ul>
                          @endif
                      </li>
                  @endforeach
              </ul>
          </nav>

          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
