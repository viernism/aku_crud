<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sekolah extends Model
{
    use HasFactory;
    protected $table = 'sekolah';
    protected $primarykey='id';
    protected $fillable = [
        'NAMA',
        'LEVEL_ID',
        'ALAMAT',
        'KOORDINAT',
        'TEL_CUST',
        'PIC_CUST',
        'AM',
        'TEL_AM',
        'STO',
        'HERO',
        'TEL_HERO',
    ];

    public function sekolahlevels()
    {
        return $this->belongsTo(LevelSekolah::class,'LEVEL_ID');
    }
}

