<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;
    protected $table = 'gedung';
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

    public function kategorigedung()
    {
        return $this->belongsTo(KategoriGedung::class,'KATEGORI','Kategori');
    }
}
