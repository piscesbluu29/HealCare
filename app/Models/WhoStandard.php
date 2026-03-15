<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhoStandard extends Model
{
    protected $table = 'who_standards';
    
    // median harus masuk sini biar bisa disimpan
    protected $fillable = ['jenis_kelamin', 'umur_bulan', 'min_3sd', 'min_2sd', 'median', 'plus_3sd'];
}