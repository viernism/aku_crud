<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTourism extends Model
{
    use HasFactory;
    protected $table = 'kategoritourism';
    protected $primarykey='id';
    protected $uniquekey='Kategori';
    protected $fillable = [
        'id',
        'Kategori'
    ];

    public function tourism()
    {
        return $this->hasMany(Tourism::class,'KATEGORI');
    }
}
