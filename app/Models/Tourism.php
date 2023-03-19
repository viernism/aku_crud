<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Tourism extends Model
{
    use HasFactory;
    protected $table = 'tourism';
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

    public function kategoritourism()
    {
        return $this->belongsTo(KategoriTourism::class,'KATEGORI');
    }
}
