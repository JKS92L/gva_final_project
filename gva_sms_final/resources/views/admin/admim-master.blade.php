
{{-- the header here  --}}
@include('admin.body.header')

  <!-- Navbar -->
 @include('admin.body.top-nav-bar')

  <!-- Main Sidebar Container -->
@include('admin.body.left-sidebar',['menus' => $menus])

{{-- content starts here  --}}
@yield('admin_content')



@include('admin.body.footer')

