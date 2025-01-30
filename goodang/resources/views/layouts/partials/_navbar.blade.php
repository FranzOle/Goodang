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
        <!-- Google Translate Dropdown -->
        <li class="nav-item">
            <div id="google_translate_element" class="nav-link"></div>
        </li>

        <!-- Sticky Note Icon with Modal -->
        <div type="button" class="nav-link" data-toggle="modal" data-target="#exampleModal" title="Peraturan">
            <i class="far fa-sticky-note"></i>
        </div>

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
                <a href="{{ route('settings.index') }}" class="dropdown-item">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Peraturan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content of the rules or guidelines -->
                @if(isset($settings->terms_and_conditions))
                    <p>{{ $settings->terms_and_conditions }}</p>
                @else
                    <p>Peraturan belum diatur oleh admin.</p>
                @endif

                @if($settings->terms_file)
                    <a href="{{ Storage::url($settings->terms_file) }}" class="btn btn-primary mt-3" download>
                        <i class="fas fa-download"></i> Unduh Peraturan (PDF/DOC)
                    </a>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- Google Translate Script -->
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en, id', // Default language of your website
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>
