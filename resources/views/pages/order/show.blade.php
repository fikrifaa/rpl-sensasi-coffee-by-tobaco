@extends('layouts.app')

@section('title', 'Order Detail #' . $order->id)

@push('style')
    <style>
        /* --- COFFEE THEME COLORS --- */
        :root {
            --espresso: #4A3728;
            --latte: #8C6239;
            --cappuccino: #C6A15B;
            --cream: #FDFBF7;
            --soft-brown: #F4ECE1;
            --charcoal: #2B2118;
            --coffee-green: #606C38;
        }

        /* Paksa background card dan garis atas */
        .main-content .card {
            background-color: var(--cream) !important;
            border: 1px solid var(--soft-brown) !important;
            border-top: 4px solid var(--espresso) !important;
        }

        /* PAKSA PREVENT BROWSER OVERRIDE PADA TABEL */
        .main-content table.table thead tr.bg-coffee-header th {
            background-color: var(--espresso) !important;
            color: #ffffff !important;
            border: none !important;
        }

        /* --- PRINT STYLES --- */
        @media print {
            .main-sidebar, .main-navbar, .section-header, .btn-print-area, footer {
                display: none !important;
            }
            .main-content {
                padding-left: 0 !important;
                padding-right: 0 !important;
                padding-top: 0 !important;
                margin-top: 0 !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
                background-color: #fff !important;
            }
            .main-content table.table thead tr.bg-coffee-header th {
                background-color: #f5f5f5 !important;
                color: #000000 !important;
                border-bottom: 2px solid #000 !important;
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order Invoice</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></div>
                    <div class="breadcrumb-item">Detail #{{ $order->id }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4 class="font-weight-bold mb-1" style="color: #4A3728 !important;">SENSASI COFFEE BY TOBACO</h4>
                                <p class="text-muted small">Sistem Informasi Manajemen Kasir & Operasional Kafe</p>
                            </div>
                            <div class="col-md-6 text-md-right btn-print-area">
                                <a href="{{ route('order.index') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button onclick="window.print()" class="btn btn-warning text-dark font-weight-bold" style="background-color: #C6A15B !important; border-color: #C6A15B !important;">
                                    <i class="fas fa-print"></i> Cetak Struk / Invoice
                                </button>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <div class="text-small font-weight-bold text-muted text-uppercase">Waktu Transaksi</div>
                                <div class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($order->transaction_time)->format('d F Y - H:i:s') }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-small font-weight-bold text-muted text-uppercase">Petugas Kasir</div>
                                <div class="font-weight-bold text-dark">{{ $order->nama_kasir }} (ID: {{ $order->id_kasir }})</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-small font-weight-bold text-muted text-uppercase">Metode & Tipe</div>
                                <div class="font-weight-bold">
                                    <span class="badge text-uppercase mr-1 text-white" style="background-color: #8C6239 !important;">{{ $order->order_type }}</span>
                                    <span class="badge text-uppercase text-white" style="background-color: #606C38 !important;">{{ $order->payment_method }}</span>
                                    @if($order->id_reservasi)
                                        <div class="small mt-1 font-weight-bold" style="color: #4A3728 !important;">Terikat Reservasi Meja #{{ $order->id_reservasi }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <thead>
                                    <tr class="bg-coffee-header">
                                        <th style="width: 50px;">#</th>
                                        <th>Nama Menu (Product)</th>
                                        <th class="text-center" style="width: 100px;">Kuantitas</th>
                                        <th class="text-right">Harga Jual</th>
                                        <th class="text-right">Total Per Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong class="text-dark">{{ $item->product->name ?? 'Menu Terhapus' }}</strong>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }} Pcs</td>
                                            <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-right font-weight-bold text-dark">
                                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4 justify-content-end">
                            <div class="col-md-5 text-right">
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="text-muted">Sub Total:</span>
                                    <span class="text-dark">Rp {{ number_format($order->sub_total, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="text-muted">Pajak (Tax):</span>
                                    <span class="text-danger">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="text-muted">Service Charge:</span>
                                    <span class="text-dark">Rp {{ number_format($order->service_charge, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <h5 class="font-weight-bold text-dark">Total Tagihan:</h5>
                                    <h5 class="font-weight-bold" style="color: #606C38 !important;">Rp {{ number_format($order->total, 0, ',', '.') }}</h5>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tunai Dibayar:</span>
                                    <span class="text-dark font-weight-bold">Rp {{ number_format($order->payment_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="font-weight-bold text-muted">Uang Kembalian:</span>
                                    <span class="font-weight-bold" style="color: #4A3728 !important;">
                                        Rp {{ number_format(max(0, $order->payment_amount - $order->total), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection