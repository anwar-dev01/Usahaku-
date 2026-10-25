<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = ['karyawan_id', 'periode', 'jumlah_hadir', 'jumlah_izin', 'jumlah_alpha', 'gaji_pokok', 'bonus', 'potongan', 'total_gaji', 'status', 'tanggal_dibayar'];

    protected function casts(): array
    {
        return [
            'tanggal_dibayar' => 'date',
        ];
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}