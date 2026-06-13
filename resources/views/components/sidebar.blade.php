<style>
    /* Mengubah latar belakang bilah menu samping (Sidebar) */
    .main-sidebar {
        background-color: #ffffff !important;
        box-shadow: 4px 0 25px rgba(74, 50, 37, 0.04) !important;
    }


    /* Menghilangkan garis pembatas default template */
    .main-sidebar #sidebar-wrapper {
        border-right: none !important;
    }

    /* Mengatur teks logo utama "Sensasi Coffee" */
    .main-sidebar .sidebar-brand a {
        color: #4A3225 !important;
        font-weight: 800 !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 15px !important;
    }

    /* Mengatur logo teks mini saat sidebar dikecilkan */
    .main-sidebar .sidebar-brand-sm a {
        color: #4A3225 !important;
        font-weight: 800 !important;
        font-size: 16px !important;
    }

    /* Mengubah teks judul kategori menu (Menu Header) */
    .main-sidebar .sidebar-menu li.menu-header {
        color: #A67B5B !important;
        font-weight: 700 !important;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        opacity: 0.85;
        font-size: 10px !important;
        margin-top: 20px;
    }

    .sidebar-mini .main-sidebar .sidebar-menu li.menu-header {
    display: none !important;
    }

    .sidebar-mini .main-sidebar {
    box-shadow: 4px 0 15px rgba(74, 50, 37, 0.06), 2px 0 6px rgba(166, 123, 91, 0.08) !important;
    }

    .sidebar-mini .main-sidebar .sidebar-menu li > ul.dropdown-menu,
.sidebar-mini .main-sidebar .sidebar-menu > ul > li > ul {
    box-shadow: 2px 4px 12px rgba(74, 50, 37, 0.10) !important;
}

/* Override shadow hover item saat sidebar collapse */
.sidebar-mini .main-sidebar .sidebar-menu > ul > li:hover > ul {
    box-shadow: 2px 4px 12px rgba(74, 50, 37, 0.10) !important;
}

    /* Mengubah gaya default teks dan ikon menu item */
    .main-sidebar .sidebar-menu li a {
        color: #6F4E37 !important;
        font-weight: 600 !important;
        transition: all 0.2s ease;
    }

    /* Mengubah warna default ikon menu */
    .main-sidebar .sidebar-menu li a i {
        color: #A67B5B !important;
        transition: all 0.2s ease;
    }

    /* Efek sorot (Hover) pada baris menu */
    .main-sidebar .sidebar-menu li a:hover {
        background-color: #FAF6F1 !important;
        color: #4A3225 !important;
    }
    .main-sidebar .sidebar-menu li a:hover i {
        color: #6F4E37 !important;
    }

    /* Gaya menu utama saat sedang aktif/terbuka (Active State) */
    .sidebar-style-2 .sidebar-menu li.active > a {
        background-color: #FAF6F1 !important;
        color: #4A3225 !important;
        font-weight: 700 !important;
    }

    /* Mengubah warna ikon pada menu yang sedang aktif */
    .sidebar-style-2 .sidebar-menu li.active > a i {
        color: #6F4E37 !important;
    }

    /* Mengubah warna indikator vertikal (garis kecil kiri) bawaan Stisla Style 2 */
    .sidebar-style-2 .sidebar-menu li.active > a:before {
        background-color: #6F4E37 !important;
        width: 4px !important;
    }

    /* Mengubah latar belakang kotak menu sub-dropdown */
    .main-sidebar .sidebar-menu li ul.dropdown-menu {
        background-color: #FAF6F1 !important;
        border-radius: 8px;
        padding-left: 5px !important;
    }

    /* Mengubah warna teks sub-menu di dalam dropdown */
    .main-sidebar .sidebar-menu li ul.dropdown-menu li a {
        color: #6F4E37 !important;
        font-weight: 500 !important;
    }

    /* Gaya sub-menu dropdown yang sedang aktif */
    .main-sidebar .sidebar-menu li ul.dropdown-menu li.active > a {
        color: #4A3225 !important;
        font-weight: 700 !important;
    }
</style>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('home') }}">Sensasi Coffee</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('home') }}">SC</a>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Menu Manajemen</li>
            
            @if(auth()->user()->role == 'admin')
            <li class="nav-item dropdown {{ Request::is('user*') || Request::is('employee*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users-cog"></i><span>User Management</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('user*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.index') }}">Users</a>
                    </li>
                    <li class="{{ Request::is('employee*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('employee.index') }}">Employees</a>
                    </li>
                </ul>
            </li>
            @endif

            @if(in_array(auth()->user()->role, ['admin', 'user']))
            <li class="nav-item dropdown {{ Request::is('inventory*') || Request::is('supplier*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-warehouse"></i><span>Warehouse</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('inventory*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('inventory.index') }}">Inventory</a>
                    </li>
                    <li class="{{ Request::is('supplier*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('supplier.index') }}">Suppliers</a>
                    </li>
                </ul>
            </li>
            @endif

            <li class="{{ Request::is('category*') ? 'active' : '' }}">
                <a href="{{ route('category.index') }}" class="nav-link"><i class="fas fa-th-large"></i><span>Categories</span></a>
            </li>

            <li class="{{ Request::is('product*') ? 'active' : '' }}">
                <a href="{{ route('product.index') }}" class="nav-link"><i class="fas fa-utensils"></i><span>Products</span></a>
            </li>

            <li class="{{ Request::is('discount*') ? 'active' : '' }}">
                <a href="{{ route('discount.index') }}" class="nav-link"><i class="fas fa-tags"></i><span>Discount</span></a>
            </li>

            @if(in_array(auth()->user()->role, ['admin', 'staff']))
            <li class="{{ Request::is('order*') ? 'active' : '' }}">
                <a href="{{ route('order.index') }}" class="nav-link"><i class="fas fa-receipt"></i><span>Orders</span></a>
            </li>

            <li class="{{ Request::is('customer*') ? 'active' : '' }}">
                <a href="{{ route('customer.index') }}" class="nav-link"><i class="fas fa-user-friends"></i><span>Customers</span></a>
            </li>

            <li class="{{ Request::is('reservation*') ? 'active' : '' }}">
                <a href="{{ route('reservation.index') }}" class="nav-link"><i class="fas fa-calendar-alt"></i><span>Reservations</span></a>
            </li>
            @endif
        </ul>
    </aside>
</div>