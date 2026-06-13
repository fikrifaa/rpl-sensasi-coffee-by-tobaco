@extends('layouts.app')

@section('title', 'Products')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        /* --- PENYELARASAN TEMA SENSASI COFFEE --- */
        
        /* Mengubah warna link teks default agar tidak biru */
        a {
            color: #6F4E37;
            transition: all 0.2s ease;
        }
        a:hover {
            color: #4A3225;
            text-decoration: none;
        }

        /* Tombol Utama (Primary) */
        .btn-primary {
            background-color: #6F4E37 !important;
            border-color: #6F4E37 !important;
            box-shadow: 0 2px 6px rgba(111, 78, 55, 0.2) !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #4A3225 !important;
            border-color: #4A3225 !important;
        }

        /* Breadcrumb Navigasi */
        .breadcrumb-item a {
            color: #A67B5B !important;
        }
        .breadcrumb-item.active {
            color: #4A3225 !important;
        }
        .section-title::before {
            background-color: #6F4E37 !important;
        }

        /* Badge Position (Primary) */
        .badge-primary {
            background-color: #FAF6F1 !important;
            color: #6F4E37 !important;
            border: 1px solid #A67B5B !important;
            font-weight: 700;
        }

        /* Input Form Focus */
        .form-control:focus {
            border-color: #A67B5B !important;
            box-shadow: 0 0 5px rgba(166, 123, 91, 0.3) !important;
        }

        /* --- MENUMPAS BIRU DI PAGINATION --- */
        .pagination .page-item .page-link {
            color: #6F4E37;
        }
        .pagination .page-item.active .page-link {
            background-color: #6F4E37 !important;
            border-color: #6F4E37 !important;
            color: #ffffff !important;
        }
        .pagination .page-item .page-link:hover {
            background-color: #FAF6F1;
            color: #4A3225;
        }

        /* --- MENUMPAS BIRU DI SELECTRIC DROPDOWN --- */
        .selectric .label {
            color: #4A3225;
        }
        .selectric-items li.selected {
            background-color: #6F4E37 !important;
            color: #ffffff !important;
        }
        .selectric-items li:hover {
            background-color: #FAF6F1 !important;
            color: #4A3225 !important;
        }
        .selectric-focus .selectric {
            border-color: #A67B5B !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Products</h1>
                <div class="section-header-button">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Add New Product</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></div>
                    <div class="breadcrumb-item">All Products</div>
                </div>
            </div>
            
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        {{-- Menampilkan alert sukses bawaan layout template --}}
                        @include('layouts.alert')

                        {{-- FIXED MODIFIKASI: Ditambahkan alert merah khusus penangkap error pembatalan hapus data --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible show fade shadow-sm">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('product.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search product name..." name="name" value="{{ request('name') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table-md table-vcenter table align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width: 120px;">Image</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Discount</th> 
                                                <th>Price</th>
                                                <th class="text-center">Stock</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center" style="width: 180px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($products as $product)
                                                <tr>
                                                    <td>
                                                        @if ($product->image)
                                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="80" class="img-thumbnail rounded shadow-sm">
                                                        @else
                                                            <span class="badge badge-light text-muted">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong class="text-dark">{{ $product->name }}</strong>
                                                        @if($product->description)
                                                            <small class="d-block text-muted text-truncate" style="max-width: 200px;">{{ $product->description }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-secondary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($product->discount)
                                                            <span class="badge badge-info">{{ $product->discount->name }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($product->discount)
                                                            {{-- Harga asli dicoret --}}
                                                            <del class="text-muted small d-block">Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                                                            {{-- Harga setelah diskon --}}
                                                            <span class="text-success font-weight-bold">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                                                        @else
                                                            {{-- Jika tidak ada diskon, tampilkan harga asli normal --}}
                                                            <span class="text-success font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center font-weight-bold">
                                                        {{ $product->stock }} Pcs
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($product->is_available && $product->stock > 0)
                                                            <span class="badge badge-success px-3">Ready</span>
                                                        @elseif ($product->stock <= 0)
                                                            <span class="badge badge-danger px-3">Empty Stock</span>
                                                        @else
                                                            <span class="badge badge-warning px-3">Disabled</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-info btn-icon mr-2">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>

                                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger btn-icon">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4 text-muted"> 
                                                        <i class="fas fa-folder-open fa-2x d-block mb-2"></i> No products found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="float-right mt-3">
                                    {{ $products->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush