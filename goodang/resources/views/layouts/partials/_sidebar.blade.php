<aside class="main-sidebar sidebar-light-light elevation-4">
    <a href="/" class="brand-link text-center border-bottom">
        <span class="brand-text font-weight-bold text-primary" style="font-size: 1.5rem;">Goodang</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-profile.png') }}" class="img-circle shadow-sm" alt="User Image" style="width: 40px; height: 40px;">
            </div>
            <div class="info ms-2">
                <a href="{{ route('users.edit', Auth::user()->id) }}" class="d-block font-weight-bold text-dark">{{ Auth::user()->name ?? 'Guest' }}</a>
                <small class="text-muted">{{ Auth::user()->email ?? '-' }}</small>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview 
                    @if(Auth::user()->role === 'admin')
                        {{ request()->is('kategori*', 'supplier*', 'gudang*', 'barang*', 'users*') ? 'menu-open' : '' }}
                    @else
                        {{ request()->is('staffkategori*', 'staffsupplier*', 'staffgudang*', 'staffbarang*') ? 'menu-open' : '' }}
                    @endif">
                    <a href="#" class="nav-link 
                        @if(Auth::user()->role === 'admin')
                            {{ request()->is('kategori*', 'supplier*', 'gudang*', 'barang*', 'users*') ? 'active bg-primary text-white' : '' }}
                        @else
                            {{ request()->is('staffkategori*', 'staffsupplier*', 'staffgudang*', 'staffbarang*') ? 'active bg-primary text-white' : '' }}
                        @endif">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-user nav-icon"></i>
                                    <p>Data User</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ Auth::user()->role === 'admin' ? route('kategori.index') : route('staffkategori.index') }}" 
                               class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'kategori*' : 'staffkategori*') ? 'active text-primary' : '' }}">
                                <i class="fa fa-shapes nav-icon"></i>
                                <p>Kategori Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Auth::user()->role === 'admin' ? route('supplier.index') : route('staffsupplier.index') }}" 
                               class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'supplier*' : 'staffsupplier*') ? 'active text-primary' : '' }}">
                                <i class="fa fa-truck nav-icon"></i>
                                <p>Supplier Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Auth::user()->role === 'admin' ? route('gudang.index') : route('staffgudang.index') }}" 
                               class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'gudang*' : 'staffgudang*') ? 'active text-primary' : '' }}">
                                <i class="fa fa-warehouse nav-icon"></i>
                                <p>Data Gudang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ Auth::user()->role === 'admin' ? route('barang.index') : route('staffbarang.index') }}" 
                               class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'barang*' : 'staffbarang*') ? 'active text-primary' : '' }}">
                                <i class="fa fa-box nav-icon"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>

                        @if(Auth::user()->role === 'user' || Auth::user()->role === 'sales')
                            <li class="nav-item">
                                <a href="{{ route('logtransaksi.index') }}" class="nav-link {{ request()->is(Auth::user()->role === 'user' ? 'logtransaksi*' : 'logtransaksi*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-history nav-icon"></i>
                                    <p>Log History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kartustok.index') }}" class="nav-link {{ request()->is(Auth::user()->role === 'user' ? 'kartustok*' : 'kartustok*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-fax nav-icon"></i>
                                    <p>Kartu Stok</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <!-- Transaksi Section -->
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
                    <li class="nav-item has-treeview 
                        {{ Auth::user()->role === 'admin' 
                            ? (request()->is('transaksi*', 'logtransaksi*') ? 'menu-open' : '') 
                            : (request()->is('stafftransaksi*', 'stafflogtransaksi*') ? 'menu-open' : '') }}">
                        <a href="#" class="nav-link 
                            {{ Auth::user()->role === 'admin' 
                                ? (request()->is('transaksi*', 'logtransaksi*') ? 'active bg-primary text-white' : '') 
                                : (request()->is('stafftransaksi*', 'stafflogtransaksi*') ? 'active bg-primary text-white' : '') }}">
                            <i class="nav-icon fas fa-dolly-flatbed"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route(Auth::user()->role === 'admin' ? 'transaksi.create' : 'stafftransaksi.create', ['type' => 'in']) }}" class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'transaksi/in*' : 'stafftransaksi/in*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-cart-plus nav-icon"></i>
                                    <p>Transaksi Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route(Auth::user()->role === 'admin' ? 'transaksi.create' : 'stafftransaksi.create', ['type' => 'out']) }}" class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'transaksi/out*' : 'stafftransaksi/out*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-cart-arrow-down nav-icon"></i>
                                    <p>Transaksi Keluar</p>
                                </a>
                            </li>

                            @if(Auth::user()->role === 'admin')
                                <li class="nav-item">
                                    <a href="{{ route('transaksi.transfer.create') }}" class="nav-link {{ request()->is('transaksi/transfer*') ? 'active text-primary' : '' }}">
                                        <i class="fa fa-arrows-alt-h nav-icon"></i>
                                        <p>Transaksi Gudang</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('logtransaksi.index') }}" class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'logtransaksi*' : 'logtransaksi*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-history nav-icon"></i>
                                    <p>Log History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kartustok.index') }}" class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'kartustok*' : 'kartustok*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-fax nav-icon"></i>
                                    <p>Kartu Stok</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'sales')
                <li class="nav-item has-treeview 
                    @if(Auth::user()->role === 'admin')
                        {{ request()->is('client*', 'laporan-penjualan*', 'tim-sales*') ? 'menu-open' : '' }}
                    @else
                        {{ request()->is('transaksi-langsung*', 'manajemen-klien*') ? 'menu-open' : '' }}
                    @endif">
                    <a href="#" class="nav-link 
                        @if(Auth::user()->role === 'admin')
                            {{ request()->is('client*', 'laporan-penjualan*', 'tim-sales*') ? 'active bg-primary text-white' : '' }}
                        @else
                            {{ request()->is('transaksi-langsung*', 'manajemen-klien*') ? 'active bg-primary text-white' : '' }}
                        @endif">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Penjualan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Menu untuk Admin -->
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ request()->is('dashboard-penjualan*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-chart-pie nav-icon"></i>
                                    <p>Dashboard Penjualan</p>
                                </a>
                            </li>@endif
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ request()->is('laporan-penjualan*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-database nav-icon"></i>
                                    <p>Laporan Penjualan</p>
                                </a>
                            </li>
                        
            
                        <!-- Menu untuk Sales -->
                        <li class="nav-item">
                            <a href="{{ Auth::user()->role === 'admin' ? route('sale.create') : '#' }}" class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'sale.create' : 'transaksi-langsun*') ? 'active text-primary' : '' }}">
                                <i class="fa fa-handshake nav-icon"></i>
                                <p>Transaksi Langsung</p>
                            </a>
                        </li>
                        
                        <!-- Menu Shared -->
                        <li class="nav-item">
                            <a href="{{ Auth::user()->role === 'admin' ? route('client.index') : '#' }}" 
                               class="nav-link {{ request()->is(Auth::user()->role === 'admin' ? 'client*' : 'manajemen-klien*') ? 'active text-primary' : '' }}">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Manajemen Klien</p>
                            </a>
                        </li>
            
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a href="#" class="nav-link {{ request()->is('tim-sales*') ? 'active text-primary' : '' }}">
                                    <i class="fa fa-user-tie nav-icon"></i>
                                    <p>Tim Sales</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>