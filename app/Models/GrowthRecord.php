<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowthRecord extends Model
{
    use HasFactory;

    // KASIH IJIN KOLOM INI BUAT DIISI
    protected $fillable = [
        'child_id', 
        'berat_badan', 
        'tinggi_badan', 
        'umur_bulan', 
        'status_stunting'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}