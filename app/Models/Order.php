<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_amount',
        'sub_total',
        'tax',
        'discount',
        'service_charge',
        'total',
        'payment_method',
        'total_item',
        'id_kasir',
        'nama_kasir',
        'transaction_time',
        'id_reservasi',
        'order_type',
    ];

    /**
     * Relasi ke tabel OrderItem (Satu Order memiliki banyak item produk yang dibeli)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_order');
    }
}