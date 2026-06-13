@extends('layouts.app')

@section('title', 'Cafe Management Dashboard')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <style>
        /* Force Tema Coffee Sensasi */
        
        /* 1. Judul Utama Dashboard */
        .section .section-header h1 {
            color: #4A3225 !important;
            font-weight: 700;
        }

        /* 2. Judul Setiap Card/Kotak */
        .card .card-header h4 {
            color: #6F4E37 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* 3. Kustomisasi Warna Ikon Statistik (Mengganti Warna Default Stisla) */
        .card-statistic-1 .card-icon.bg-primary {
            background-color: #A67B5B !important; /* Warna Latte */
        }
        .card-statistic-1 .card-icon.bg-danger {
            background-color: #6F4E37 !important; /* Warna Espresso */
        }
        .card-statistic-1 .card-icon.bg-warning {
            background-color: #D2B48C !important; /* Warna Caramel */
        }
        .card-statistic-1 .card-icon.bg-success {
            background-color: #4A3225 !important; /* Warna Dark Coffee Bean */
        }

        /* 4. Angka Statistik */
        .card-statistic-1 .card-body {
            color: #4A3225 !important;
            font-weight: 800 !important;
            font-size: 22px !important;
        }

        /* 5. Tombol Utama (Manage Inventory) */
        .btn-primary {
            background: linear-gradient(135deg, #A67B5B, #6F4E37) !important;
            border: none !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 10px rgba(111, 78, 55, 0.15) !important;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            opacity: 0.9 !important;
            box-shadow: 0 4px 15px rgba(111, 78, 55, 0.25) !important;
        }

        /* 6. Tombol Garis Tepi (Quick Actions) */
        .btn-outline-primary {
            color: #A67B5B !important;
            border-color: #A67B5B !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
        }
        .btn-outline-primary:hover {
            background-color: #A67B5B !important;
            color: #fff !important;
        }

        .btn-outline-success {
            color: #6F4E37 !important;
            border-color: #6F4E37 !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
        }
        .btn-outline-success:hover {
            background-color: #6F4E37 !important;
            color: #fff !important;
        }

        /* 7. Desain Tabel Stok */
        .table thead th {
            background-color: #FAF6F1 !important;
            color: #4A3225 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #E6DEC9 !important;
        }
        .table tbody td {
            color: #5a5c69 !important;
            font-weight: 600;
        }

        /* 8. Quick Actions List */
        .media .media-title {
            color: #4A3225 !important;
            font-weight: 700 !important;
            font-size: 14px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Cafe Operations Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Staff</h4>
                            </div>
                            <div class="card-body">
                                {{ \App\Models\User::count() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-coffee"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Menu / Products</h4>
                            </div>
                            <div class="card-body">
                                {{ class_exists('App\Models\Product') ? \App\Models\Product::count() : 0 }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Inventory Items</h4>
                            </div>
                            <div class="card-body">
                                {{ \App\Models\Inventory::count() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Active Suppliers</h4>
                            </div>
                            <div class="card-body">
                                {{ \App\Models\Supplier::count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Current Stock Monitor</h4>
                            <div class="card-header-action">
                                <a href="{{ route('inventory.index') }}" class="btn btn-primary">Manage Inventory</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table-striped mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Current Stock</th>
                                            <th>Supplier</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(\App\Models\Inventory::with('supplier')->latest()->take(5)->get() as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->stock }} {{ $item->unit }}</td>
                                                <td>{{ $item->supplier->name ?? 'No Supplier' }}</td>
                                                <td>
                                                    @if($item->stock <= 5)
                                                        <span class="badge badge-danger">Restock Needed</span>
                                                    @elseif($item->stock <= 15)
                                                        <span class="badge badge-warning">Limited</span>
                                                    @else
                                                        <span class="badge badge-success">Safe</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted p-4">No inventory items found. Go to Inventory module to add raw materials.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Quick Actions & Shortcuts</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                <li class="media mb-4">
                                    <div class="media-body">
                                        <h6 class="media-title">Quick Logistik</h6>
                                        <span class="text-small text-muted d-block mb-2">Tambah restock bahan mentah kopi atau susu ke gudang.</span>
                                        <a href="{{ route('inventory.create') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus"></i> Add Stock</a>
                                    </div>
                                </li>
                                <li class="media mb-4">
                                    <div class="media-body">
                                        <h6 class="media-title">Mitra Baru</h6>
                                        <span class="text-small text-muted d-block mb-2">Daftarkan distributor atau supplier biji kopi baru.</span>
                                        <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-outline-success"><i class="fas fa-truck"></i> Add Supplier</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
@endpush