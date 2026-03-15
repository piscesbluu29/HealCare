<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'jenis_kelamin',
        'tgl_lahir',
    ];

    // Ganti nama fungsi dari 'user' ke 'parent' supaya sinkron sama Controller
    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function records()
    {
        return $this->hasMany(GrowthRecord::class);
    }
}