<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['no_rekam_medik', 'nama_pasien', 'nik', 'alamat'];

    public function visit()
    {
        return $this->hasOne(Visit::class, 'no_rekam_medik', 'no_rekam_medik');
    }
}
