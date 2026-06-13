@extends('layouts.app')

@section('title', 'Edit Product')

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
                <h1>Edit Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></div>
                    <div class="breadcrumb-item">Edit Product</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Modify Product Information</h2>
                <p class="section-lead">Perbarui data menu kafe Anda dengan filling form di bawah ini.</p>

                <div class="card">
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                       
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $product->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control selectric @error('category_id') is-invalid @enderror">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-label">Discount</label>
                                    <select name="discount_id" class="form-control selectric @error('discount_id') is-invalid @enderror">
                                        <option value="">-- No Discount --</option>
                                        @foreach ($discounts as $discount)
                                            <option value="{{ $discount->id }}" {{ old('discount_id', $product->discount_id) == $discount->id ? 'selected' : '' }}>
                                                {{ $discount->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('discount_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Price (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           name="price" value="{{ old('price', $product->price) }}">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Stock Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                           name="stock" value="{{ old('stock', $product->stock) }}">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="d-block">Status Availability</label>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="is_available" value="1" class="custom-switch-input" {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description font-weight-bold text-success">Available for Order</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Replace Photo Product Menu</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" onchange="previewImageUpdate(event)">
                                <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah foto menu.</small>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="img-holder border rounded d-flex align-items-center justify-content-center bg-light" style="width: 150px; height: 150px; overflow: hidden;">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" id="preview_image_up" style="max-width: 100%; max-height: 100%;">
                                    @else
                                        <img src="" alt="Preview" id="preview_image_up" style="max-width: 100%; max-height: 100%; display: none;">
                                        <span id="preview_placeholder_up" class="text-muted small text-center p-2">No image active</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('product.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <script>
        function previewImageUpdate(event) {
            var reader = new FileReader();
            var output = document.getElementById('preview_image_up');
            var placeholder = document.getElementById('preview_placeholder_up');
            
            reader.onload = function() {
                output.src = reader.result;
                output.style.display = 'block';
                if(placeholder) placeholder.style.display = 'none';
            }
            
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endpush