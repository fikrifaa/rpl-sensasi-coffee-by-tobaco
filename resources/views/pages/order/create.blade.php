@extends('layouts.app')

@section('title', 'Create Order (POS)')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        /* --- COFFEE THEME POS CUSTOM STYLES --- */
        :root {
            --espresso: #4A3728;
            --latte: #8C6239;
            --cappuccino: #C6A15B;
            --cream: #FDFBF7;
            --soft-brown: #F4ECE1;
            --coffee-green: #606C38;
            --coffee-red: #9A031E;
        }

        .card .card-header h4 {
            color: var(--espresso) !important;
            font-weight: 700;
        }

        /* Menu Grid Custom Styling */
        .item-product {
            transition: all 0.25s ease-in-out;
            background-color: var(--cream) !important;
            border-color: var(--soft-brown) !important;
        }

        .item-product:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(74, 55, 40, 0.15) !important;
            border-color: var(--latte) !important;
        }

        .item-product h6 {
            color: var(--espresso) !important;
            font-weight: 600;
        }

        /* Customizing Right Billing Column Table Header */
        #table-cart th {
            background-color: var(--soft-brown) !important;
            color: var(--espresso) !important;
            font-weight: bold;
        }

        /* Form Controls focus state */
        .form-control:focus {
            border-color: var(--latte) !important;
            box-shadow: 0 0 0 0.2rem rgba(140, 98, 57, 0.25) !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Point of Sale (POS)</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <form action="{{ route('order.store') }}" method="POST" id="form-order">
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card" style="border-top: 4px solid var(--espresso) !important;">
                                <div class="card-header">
                                    <h4>Sensasi Coffee Menu</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row" style="max-height: 600px; overflow-y: auto;">
                                        @foreach ($products as $product)
                                            <div class="col-md-4 col-sm-6 mb-3">
                                                <div class="card h-100 border text-center p-2 shadow-sm item-product" 
                                                     style="cursor: pointer;"
                                                     data-id="{{ $product->id }}"
                                                     data-name="{{ $product->name }}"
                                                     data-price="{{ $product->final_price }}">
                                                    
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded mb-2" style="height: 100px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded mb-2 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                            <i class="fas fa-coffee fa-2x text-muted"></i>
                                                        </div>
                                                    @endif
                                                    
                                                    <h6 class="text-truncate mb-1">{{ $product->name }}</h6>
                                                    
                                                    @if($product->discount)
                                                        <del class="text-muted small">Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                                                        <span class="font-weight-bold d-block" style="color: #606C38 !important;">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                                                    @else
                                                        <span class="font-weight-bold d-block" style="color: #8C6239 !important;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                    @endif
                                                    
                                                    <small class="text-muted">Stok: {{ $product->stock }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card" style="border-top: 4px solid var(--latte) !important; background-color: var(--cream) !important;">
                                <div class="card-header">
                                    <h4>Billing Detail</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped" id="table-cart">
                                            <thead>
                                                <tr>
                                                    <th>Menu</th>
                                                    <th style="width: 100px;">Qty</th>
                                                    <th>Price</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="empty-cart-row">
                                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada menu dipilih</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark">Order Type</label>
                                        <select class="form-control selectric" name="order_type" id="order_type">
                                            <option value="dinein">Dine In (Makan di tempat)</option>
                                            <option value="reservation">Reservation (Reservasi)</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="group-reservation" style="display: none;">
                                        <label class="font-weight-bold text-dark">Pilih Data Reservasi</label>
                                        <select class="form-control selectric" name="id_reservasi">
                                            <option value="">-- Pilih Reservasi Meja --</option>
                                            @foreach($reservations as $res)
                                                <option value="{{ $res->id }}">Meja {{ $res->id }} - {{ $res->name ?? 'No Name' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark">Payment Method</label>
                                        <select class="form-control selectric" name="payment_method">
                                            <option value="Cash">Cash (Tunai)</option>
                                            <option value="QRIS">QRIS / Digital Payment</option>
                                            <option value="Transfer">Bank Transfer</option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="sub_total" id="input-sub_total" value="0">
                                    <input type="hidden" name="tax" id="input-tax" value="0">
                                    <input type="hidden" name="discount" id="input-discount" value="0">
                                    <input type="hidden" name="service_charge" id="input-service" value="0">
                                    <input type="hidden" name="total" id="input-total" value="0">

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Sub Total</span>
                                        <span id="text-sub_total" class="text-dark font-weight-bold">Rp 0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Pajak (10%)</span>
                                        <span id="text-tax" class="font-weight-bold" style="color: #9A031E !important;">Rp 0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Service Charge</span>
                                        <span id="text-service" class="text-dark font-weight-bold">Rp 0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3 border-top pt-2">
                                        <h5 class="font-weight-bold text-dark">Total Akhir</h5>
                                        <h5 class="font-weight-bold" id="text-total" style="color: #606C38 !important;">Rp 0</h5>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark">Uang Dibayar (Payment Amount)</label>
                                        <input type="number" class="form-control form-control-lg font-weight-bold" name="payment_amount" id="payment_amount" required value="0" style="color: #606C38 !important;">
                                    </div>

                                    <div class="d-flex justify-content-between mb-4">
                                        <span class="font-weight-bold text-dark">Kembalian</span>
                                        <span class="font-weight-bold" id="text-change" style="color: #9A031E !important;">Rp 0</span>
                                    </div>

                                    <button type="submit" class="btn btn-lg btn-block shadow text-white font-weight-bold" style="background-color: #606C38 !important; border-color: #606C38 !important;">
                                        <i class="fas fa-receipt"></i> Proses Transaksi & Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    
    <script>
        let cart = {};

        $(document).ready(function() {
            $('#order_type').change(function() {
                if ($(this).val() === 'reservation') {
                    $('#group-reservation').fadeIn();
                } else {
                    $('#group-reservation').fadeOut().find('select').val('').change();
                }
            });

            $('.item-product').click(function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let price = parseInt($(this).data('price'));

                if (cart[id]) {
                    cart[id].qty++;
                } else {
                    cart[id] = { id: id, name: name, price: price, qty: 1 };
                }
                renderCart();
            });

            $('#payment_amount').on('input', function() {
                calculateTotals();
            });
        });

        function renderCart() {
            let container = $('#table-cart tbody');
            container.find('.cart-item-row').remove();

            let keys = Object.keys(cart);
            if (keys.length === 0) {
                $('#empty-cart-row').show();
            } else {
                $('#empty-cart-row').hide();
                keys.forEach((id, index) => {
                    let item = cart[id];
                    let row = `
                        <tr class="cart-item-row">
                            <td class="text-dark font-weight-bold">
                                ${item.name}
                                <input type="hidden" name="items[${index}][id_product]" value="${item.id}">
                                <input type="hidden" name="items[${index}][price]" value="${item.price}">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm input-qty" 
                                       name="items[${index}][quantity]" value="${item.qty}" min="1" 
                                       data-id="${item.id}" style="height: 28px;">
                            </td>
                            <td class="text-dark">Rp ${(item.price * item.qty).toLocaleString('id-ID')}</td>
                            <td class="text-right">
                                <button type="button" class="btn btn-sm btn-danger btn-remove" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    container.append(row);
                });
            }

            $('.input-qty').on('change input', function() {
                let id = $(this).data('id');
                let newQty = parseInt($(this).val());
                if (newQty >= 1) {
                    cart[id].qty = newQty;
                    renderCart();
                }
            });

            $('.btn-remove').click(function() {
                let id = $(this).data('id');
                delete cart[id];
                renderCart();
            });

            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = 0;
            Object.keys(cart).forEach(id => {
                subtotal += (cart[id].price * cart[id].qty);
            });

            let tax = Math.round(subtotal * 0.10); 
            let service = subtotal > 0 ? 2000 : 0; 
            let total = subtotal + tax + service;

            let paymentAmount = parseInt($('#payment_amount').val()) || 0;
            let change = paymentAmount - total;

            $('#input-sub_total').val(subtotal);
            $('#input-tax').val(tax);
            $('#input-service').val(service);
            $('#input-total').val(total);

            $('#text-sub_total').text('Rp ' + subtotal.toLocaleString('id-ID'));
            $('#text-tax').text('Rp ' + tax.toLocaleString('id-ID'));
            $('#text-service').text('Rp ' + service.toLocaleString('id-ID'));
            $('#text-total').text('Rp ' + total.toLocaleString('id-ID'));
            
            if (change >= 0) {
                $('#text-change').css('color', '#606C38', 'important').text('Rp ' + change.toLocaleString('id-ID'));
            } else {
                $('#text-change').css('color', '#9A031E', 'important').text('Rp 0 (Kurang: Rp ' + Math.abs(change).toLocaleString('id-ID') + ')');
            }
        }
    </script>
@endpush