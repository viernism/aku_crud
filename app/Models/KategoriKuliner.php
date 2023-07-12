<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKuliner extends Model
{
    use HasFactory;
    protected $table = 'KategoriKuliner';
    protected $primarykey='id';
    protected $uniquekey='Kategori';
    protected $fillable = [
        'id',
        'Kategori'
    ];

    public function kuliner()
    {
        return $this->hasMany(Kuliner::class,'KATEGORI','Kategori');
    }
}
