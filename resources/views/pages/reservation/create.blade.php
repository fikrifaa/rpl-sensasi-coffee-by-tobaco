@extends('layouts.app')

@section('title', 'Create Reservation')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                <h1>Create Reservation</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Reservations</a></div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">New Reservation</h2>
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                        </div>
                    </div>
                @endif

                <div class="card">
                    <form action="{{ route('reservation.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            
                            <div class="form-group">
                                <label>Customer Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                    class="form-control @error('customer_name') is-invalid @enderror" 
                                    name="customer_name" 
                                    value="{{ old('customer_name') }}"
                                    placeholder="Contoh permisalan: Ahmad Subagja">
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Customer Phone <span class="text-danger">*</span></label>
                                <input type="text" 
                                    class="form-control @error('customer_phone') is-invalid @enderror" 
                                    name="customer_phone" 
                                    value="{{ old('customer_phone') }}"
                                    placeholder="Contoh permisalan: 081234567890">
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Tanggal Reservasi <span class="text-danger">*</span></label>
                                <input type="date" 
                                    class="form-control @error('reservation_date') is-invalid @enderror" 
                                    id="reservation_date" 
                                    name="reservation_date" 
                                    value="{{ old('reservation_date') }}" 
                                    required>
                                @error('reservation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Jam Reservasi <span class="text-danger">*</span></label>
                                <input type="time" 
                                    class="form-control @error('reservation_time') is-invalid @enderror" 
                                    id="reservation_time" 
                                    name="reservation_time" 
                                    value="{{ old('reservation_time') }}" 
                                    required>
                                @error('reservation_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Table Number (Nomor Meja) <span class="text-danger">*</span></label>
                                <input type="text" 
                                    class="form-control @error('table_number') is-invalid @enderror" 
                                    name="table_number" 
                                    value="{{ old('table_number') }}"
                                    placeholder="Contoh permisalan: Meja 05 atau Meja VIP-1">
                                <small class="text-muted d-block mt-1">Sistem akan otomatis menolak jika nomor meja sudah dibooking pada tanggal yang sama.</small>
                                @error('table_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Status Reservasi</label>
                                <select class="form-control selectric" name="status" id="status">
                                    <option value="pending" selected>Menunggu Konfirmasi (Pending)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Notes (Catatan Tambahan)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                    name="notes" 
                                    rows="3" 
                                    placeholder="Contoh catatan: Minta pasang lilin ulang tahun / posisi dekat jendela / alergi seafood.">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('reservation.index') }}" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary" type="submit">Create Reservation</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection