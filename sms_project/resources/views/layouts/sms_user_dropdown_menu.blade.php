<div class="card card-widget widget-user shadow-lg">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header text-white" style="background: url('{{ asset('images/bg-profile.jpg') }}') center center;">
        <h3 class="widget-user-username text-right">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
        {{-- <h5 class="widget-user-desc text-right">{{ Auth::user()->role }}</h5> --}}
    </div>
    <div class="widget-user-image">
        <img class="img-circle elevation-2" src="{{ asset('images/profile/' . Auth::user()->profile_image) }}" alt="User Avatar">
    </div>
    <div class="card-footer">
        <div class="text-center mb-3">
            <h5>{{ Auth::user()->email }}</h5>
        </div>
        <div class="row">
            <!-- View Profile Button -->
            <div class="col-sm-6">
                <div class="description-block">
                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="btn btn-primary btn-block">View Profile</a>
                </div>
            </div>
            <!-- Logout Button -->
            <div class="col-sm-6">
                <div class="description-block">
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-block"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
