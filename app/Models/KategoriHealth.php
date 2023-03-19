<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriHealth extends Model
{
    use HasFactory;
    protected $table = 'kategorihealth';
    protected $primarykey='id';
    protected $fillable = [
        'id',
        'Kategori'
    ];

    public function health()
    {
        return $this->hasMany(Health::class,'KATEGORI');
    }
}
