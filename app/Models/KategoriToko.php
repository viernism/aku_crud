<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriToko extends Model
{
    use HasFactory;
    protected $table = 'kategoritoko';
    protected $primarykey='id';
    protected $fillable = [
        'id',
        'Kategori'
    ];

    public function toko()
    {
        return $this->hasMany(Toko::class,'KATEGORI');
    }
}
