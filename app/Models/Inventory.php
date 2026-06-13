<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Sekarang supplier_id udah diizinkan untuk mass assignment lewat Eloquent
    protected $fillable = [
        'name', 
        'stock', 
        'unit', 
        'supplier_id'
    ];

    /**
     * Relasi ke model Supplier
     * Satu item inventory dipasok oleh satu Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}