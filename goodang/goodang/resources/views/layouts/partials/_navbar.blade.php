<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
  
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
                <div class="image mr-2">
                    <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-profile.png') }}" class="img-circle" alt="User Image" style="width: 30px; height: 30px;">
                </div>
                <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Guest' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-header">
                    <strong>{{ Auth::user()->name ?? 'Guest' }}</strong>
                    <p class="text-muted mb-0">{{ Auth::user()->email ?? 'Tidak ada email' }}</p>
                    <p class="text-muted">Role: {{ ucfirst(Auth::user()->role) ?? 'User' }}</p>
                    @if(Auth::user()->role === 'staff')
                        <p class="text-muted">Gudang: <span>{{ Auth::user()->gudang->nama ?? 'Tidak ditugaskan' }}</span></p>
                    @endif
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('profiles.show', Auth::user()->id) }}" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                @if(Auth::user()->role === 'admin')
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cogs mr-2"></i> Setting Website
                </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('users.logout') }}" class="dropdown-item text-danger">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  