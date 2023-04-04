<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LevelSekolah extends Model
{
    use HasFactory;
    protected $table = 'sekolahlevels';
    protected $primarykey='id';
    protected $uniquekey='LEVEL';
    protected $fillable = [
        'id',
        'LEVEL'
    ];

    public function sekolah()
    {
        return $this->hasMany(Sekolah::class,'LEVEL');
    }
}
