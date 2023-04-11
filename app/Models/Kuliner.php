<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    use HasFactory;
    protected $table = 'kuliner';
    protected $primarykey='id';
    protected $fillable = [
        'NAMA',
        'KATEGORI',
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

    public function kategorikuliner()
    {
        return $this->belongsTo(KategoriKuliner::class,'KATEGORI','Kategori');
    }
}
