<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_id', 'user_id', 'tipe', 'nominal', 'tanggal', 'keterangan', 'bukti'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}