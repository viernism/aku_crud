<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriOffice extends Model
{
    use HasFactory;
    protected $table = 'kategorioffice';
    protected $primarykey='id';
    protected $uniquekey='Kategori';
    protected $fillable = [
        'id',
        'Kategori'
    ];

    public function office()
    {
        return $this->hasMany(Office::class,'KATEGORI','Kategori');
    }
}
