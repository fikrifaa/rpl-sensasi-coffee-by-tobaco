<style>
    /* Mengubah latar belakang navbar utama dengan gradasi warna kopi */
    .navbar-bg {
        background: linear-gradient(135deg, #A67B5B, #6F4E37) !important;
        height: 70px !important;
    }
    
    /* Memastikan ikon dan teks di navbar atas berwarna cream cerah */
    .main-navbar .nav-link {
        color: #FAF6F1 !important;
    }
    .main-navbar .nav-link:hover {
        opacity: 0.85;
    }
    
    /* Perubahan gaya menu dropdown profil agar minimalis */
    .navbar-right .dropdown-menu {
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 30px rgba(74, 50, 37, 0.08) !important;
        padding: 10px 0 !important;
    }
    
    /* Mengubah teks judul di dalam dropdown */
    .navbar-right .dropdown-menu .dropdown-title {
        color: #4A3225 !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 10px !important;
        padding: 10px 20px !important;
    }
    
    /* Mengubah baris menu di dalam dropdown */
    .navbar-right .dropdown-menu .dropdown-item {
        color: #6F4E37 !important;
        font-weight: 600;
        padding: 10px 20px !important;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }
    
    /* Efek hover ketika menu dropdown disorot */
    .navbar-right .dropdown-menu .dropdown-item:hover {
        background-color: #FAF6F1 !important;
        color: #A67B5B !important;
    }
    
    /* Ikon di dalam dropdown */
    .navbar-right .dropdown-menu .dropdown-item i {
        margin-right: 12px !important;
        font-size: 14px !important;
        width: 20px;
        text-align: center;
    }
    
    /* Pembatas garis di dalam dropdown */
    .navbar-right .dropdown-divider {
        border-top: 1px solid #FAF6F1 !important;
        margin: 5px 0 !important;
    }

    /* Kustomisasi Modal Detail Profile */
    .coffee-modal .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }
    .coffee-modal .modal-header {
        background: linear-gradient(135deg, #A67B5B, #6F4E37);
        color: #fff;
        border-bottom: none;
    }
    .coffee-modal .modal-header .close {
        color: #fff;
        opacity: 0.8;
    }
    .coffee-modal .profile-avatar-detail {
        width: 90px;
        height: 90px;
        border: 4px solid #FAF6F1;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .coffee-modal .badge-role {
        background-color: #FAF6F1;
        color: #6F4E37;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 20px;
    }
    .coffee-modal .detail-label {
        font-size: 12px;
        color: #8898aa;
        font-weight: 600;
        margin-bottom: 2px;
    }
    .coffee-modal .detail-value {
        font-size: 15px;
        color: #4A3225;
        font-weight: 700;
        margin-bottom: 15px;
    }
</style>

<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form>
    
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-6.png') }}" class="rounded-circle mr-1">
                
                <div class="d-sm-none d-lg-inline-block">
                    Hi, {{ auth()->user()->name }} 
                    (
                        @if(auth()->user()->role == 'admin') Admin 
                        @elseif(auth()->user()->role == 'staff') Kasir 
                        @else Staff Gudang 
                        @endif
                    )
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    Akses: 
                    @if(auth()->user()->role == 'admin') Admin Utama
                    @elseif(auth()->user()->role == 'staff') Staff Kasir
                    @else Logistik / Gudang
                    @endif
                </div>
                
                <a href="#" data-toggle="modal" data-target="#profileDetailModal" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>

                <div class="dropdown-divider"></div>
                <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

<div class="modal fade coffee-modal" id="profileDetailModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block position-relative">
                <button type="text" class="close position-absolute" style="right: 15px; top: 10px;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="mt-3">
                    <img alt="image" src="{{ asset('img/avatar/avatar-6.png') }}" class="rounded-circle profile-avatar-detail mb-3">
                    <h5 class="modal-title text-white font-weight-bold mb-2" id="profileModalLabel">{{ auth()->user()->name }}</h5>
                    <span class="badge badge-role">
                        @if(auth()->user()->role == 'admin') Admin Utama
                        @elseif(auth()->user()->role == 'staff') Staff Kasir
                        @else Logistik / Gudang
                        @endif
                    </span>
                </div>
            </div>
            <div class="modal-body bg-white p-4">
                <div>
                    <div class="detail-label">ALAMAT EMAIL</div>
                    <div class="detail-value">{{ auth()->user()->email }}</div>
                </div>
                <div>
                    <div class="detail-label">STATUS AKUN</div>
                    <div class="detail-value text-success">
                        <i class="fas fa-check-circle mr-1"></i> Aktif (Internal)
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-block font-weight-bold mt-2" style="border-radius: 10px;" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>