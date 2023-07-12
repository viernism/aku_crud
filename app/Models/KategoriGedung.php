<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriGedung extends Model
{
    use HasFactory;
    protected $table = 'KategoriGedung';
    // protected $primarykey='id';
    protected $uniquekey='Kategori';
    protected $fillable = [
        'id',
        'Kategori'
    ];

    public function gedung()
    {
        return $this->hasMany(Gedung::class,'KATEGORI','Kategori');
    }
}
