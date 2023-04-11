<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuscen extends Model
{
    use HasFactory;
    protected $table = 'kategoriBuscens';
    protected $primarykey='id';
    protected $uniquekey='Kategori';
    protected $fillable = [
        'id',
        'Kategori'
    ];

    public function buscen()
    {
        return $this->hasMany(Buscen::class,'KATEGORI','Kategori');
    }
}
