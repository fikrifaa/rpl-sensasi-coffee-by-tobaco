@extends('layouts.app')

@section('title', 'Add Employee')

@push('style')
    <style>
        /* --- PENYELARASAN TEMA SENSASI COFFEE --- */
        a {
            color: #6F4E37;
        }
        a:hover {
            color: #4A3225;
            text-decoration: none;
        }
        
        /* Tombol Simpan */
        .btn-primary {
            background-color: #6F4E37 !important;
            border-color: #6F4E37 !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #4A3225 !important;
            border-color: #4A3225 !important;
        }
        
        /* Focus Outline untuk Form Input & Textarea (Membasmi Ring Biru Stisla) */
        .form-control:focus {
            border-color: #A67B5B !important;
            box-shadow: 0 0 5px rgba(166, 123, 91, 0.3) !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Employee</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('employee.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Position</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}">
                                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Salary</label>
                                <input type="number" class="form-control @error('salary') is-invalid @enderror" name="salary" value="{{ old('salary') }}">
                                @error('salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Date Of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Joining Date</label>
                                <input type="date" class="form-control @error('date_of_joining') is-invalid @enderror" name="date_of_joining" value="{{ old('date_of_joining') }}">
                                @error('date_of_joining') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" style="height: auto;">{{ old('address') }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('employee.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection