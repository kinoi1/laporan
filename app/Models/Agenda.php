<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_agenda',
        'tanggal_diterima',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'pengirim',
        'attachment'
    ];
}
