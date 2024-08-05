<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['no_rekam_medik','jumlah_kunjungan'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'no_rekam_medik', 'no_rekam_medik');
    }
}
