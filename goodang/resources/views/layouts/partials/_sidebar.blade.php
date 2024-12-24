
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <span class="brand-text font-weight-light">Goodang</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
          <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-profile.png') }}" class="img-circle" alt="User Image">
      </div>
      <div class="info">
          <a href="{{ route('users.edit', Auth::user()->id) }}" class="d-block">{{ Auth::user()->name ?? 'Guest' }}</a>
          <div class="user-card position-absolute bg-light border p-2 rounded shadow" style="100%; left: 0; z-index: 10; width: 200px;">
            <strong>Username:</strong> {{ Auth::user()->name ?? 'Guest' }}<br>
            <strong>Email:</strong> {{ Auth::user()->email ?? '-' }}<br>
            <strong>Role:</strong> {{ ucfirst(Auth::user()->role) ?? '-' }}
        </div>
        </div>
  </div>
  
    <!-- Sidebar Menu -->
    <nav class="mt-2">
     
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Master
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if(Auth::user()->role === 'admin')
          <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link">
                  <i class="fa fa-regular fa-user"></i>
                  <p>Data User</p>
              </a>
          </li>
          @endif

            <li class="nav-item">
              <a href="{{ Auth::user()->role === 'admin' ? route('kategori.index') : route('staffkategori.index') }}" class="nav-link">
                <i class="fa fa-regular fa-shapes"></i>
                <p>Kategori Barang</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ Auth::user()->role === 'admin' ? route('supplier.index') : route('staffsupplier.index')}}" class="nav-link">
                <i class="fa fa-regular fa-truck"></i>
                <p>Supplier Barang</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ Auth::user()->role === 'admin' ? route('gudang.index') : route('staffgudang.index')}}" class="nav-link">
                <i class="fa fa-regular fa-warehouse"></i>
                <p>Data Gudang</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ Auth::user()->role === 'admin' ? route('barang.index') : route('staffbarang.index')}}" class="nav-link">
                <i class="fa fa-solid fa-box"></i>
                <p>Data Barang</p>
              </a>
            </li>

          </ul>
        </li>
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                  Transaksi
                  <i class="right fas fa-angle-left"></i>
              </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="{{ route('transaksi.create', ['type' => 'in']) }}" class="nav-link">
                      <i class="fa fas fa-indent"></i>
                      <p>Transaksi Masuk</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('transaksi.create', ['type' => 'out']) }}" class="nav-link">
                      <i class="fa fas fa-outdent"></i>
                      <p>Transaksi Keluar</p>
                  </a>
              </li>
              @if(Auth::user()->role === 'admin')
            <li class="nav-item">
              <a href="{{ route('transaksi.transfer.create') }}" class="nav-link">
                <i class="fa fas fa-exchange-alt"></i>
                  <p>Transaksi Gudang</p>
              </a>
            </li>
            @endif
              <li class="nav-item">
                  <a href="#" class="nav-link">
                      <i class="fa fas fa-history"></i>
                      <p>Log History</p>
                  </a>
              </li>
          </ul>
      </li>
      
        @endif
        <li class="nav-item">
          <a href="{{ route('users.logout') }}" class="nav-link">
            <i class="fa fa-solid fa-user-minus"></i>
            <p>Log-out</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>