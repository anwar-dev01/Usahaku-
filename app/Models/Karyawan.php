<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nama', 'jabatan', 'tipe_gaji', 'gaji_pokok', 'no_hp', 'tanggal_masuk', 'status'];

    protected function casts(): array
    {
        return [
            'tanggal_masuk' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}