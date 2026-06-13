<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'discount_id',
        'name', 
        'description', 
        'image', 
        'price', 
        'stock', 
        'is_available'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Menambahkan relasi ke model Discount
    public function discount() {
        return $this->belongsTo(Discount::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'id_product');
    }

    /**
     * Accessor untuk menghitung harga setelah diskon secara otomatis.
     * Kode ini membuat properti virtual baru bernama 'final_price'.
     * Cara panggil di Blade: $product->final_price
     */
    public function getFinalPriceAttribute()
    {
        // Pastikan produk memiliki relasi diskon
        if ($this->discount) {
            /**
             * PENTING: 
             * Ganti '$this->discount->value' di bawah sesuai nama kolom 
             * angka persen di tabel discounts kamu (misal: 'percentage' atau 'nilai').
             */
            $potongan = $this->price * ($this->discount->value / 100);
            return $this->price - $potongan;
        }

        // Jika tidak ada diskon, kembalikan harga asli produk
        return $this->price;
    }
}