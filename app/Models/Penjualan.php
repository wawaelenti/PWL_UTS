<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PenjualanDetail;
use App\Models\User;

class Penjualan extends Model
{
     protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal'
    ];

    protected $casts = [
        'penjualan_tanggal' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function getTotalAttribute()
    {
        return $this->details->sum(fn($d) => $d->harga * $d->jumlah);
    }
}
