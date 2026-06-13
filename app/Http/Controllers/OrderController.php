<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // <-- INI DIA YANG KITA TAMBAHKAN AGAR LARAVEL GAK BINGUNG
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('nama_kasir', 'like', '%' . $request->name . '%')
                  ->orWhere('order_type', 'like', '%' . $request->name . '%');
        }

        $orders = $query->latest()->paginate(5);

        return view('pages.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all(); 
        
        // Sekarang Laravel sudah tahu kalau Schema ini adalah alat cek database, bukan controller ghaib
        $reservations = Schema::hasTable('reservations') ? DB::table('reservations')->get() : []; 

        return view('pages.order.create', compact('products', 'reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sub_total'       => 'required|numeric',
            'tax'             => 'required|numeric',
            'discount'        => 'required|numeric',
            'total'           => 'required|numeric',
            'payment_amount'  => 'required|numeric',
            'payment_method'  => 'required|string',
            'order_type'      => 'required|in:dinein,reservation',
            'items'           => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'sub_total'        => (int)$request->sub_total,
                'tax'              => (int)$request->tax,
                'discount'         => (int)$request->discount,
                'service_charge'   => (int)($request->service_charge ?? 0),
                'total'            => (int)$request->total,
                'payment_amount'   => (int)$request->payment_amount,
                'payment_method'   => $request->payment_method,
                'total_item'       => collect($request->items)->sum('quantity'),
                'id_kasir'         => auth()->id() ?? 1, 
                'nama_kasir'       => auth()->user()->name ?? 'Kasir Default',
                'transaction_time' => Carbon::now()->toDateTimeString(),
                'id_reservasi'     => $request->id_reservasi,
                'order_type'       => $request->order_type,
            ]);

            foreach ($request->items as $item) {
                OrderItem::create([
                    'id_order'   => $order->id,
                    'id_product' => $item['id_product'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            DB::commit();
            return redirect()->route('order.index')->with('success', 'Order successfully created!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['orderItems.product'])->findOrFail($id);
        return view('pages.order.show', compact('order'));
    }

    public function edit(string $id) {}
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);
            $order->orderItems()->delete();
            $order->delete();

            DB::commit();
            return redirect()->route('order.index')->with('success', 'Order successfully deleted!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('order.index')->with('error', 'Failed to delete order.');
        }
    }
}