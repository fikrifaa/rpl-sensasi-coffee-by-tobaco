@extends('layouts.app')

@section('title', 'Customer Create')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
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
                <h1>Create Customer</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Customers</a></div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Add New Customer</h2>
                <div class="card">
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('customer.index') }}" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @endpush