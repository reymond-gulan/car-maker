<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturers extends Model
{
    use HasFactory;

    protected $primaryKey = 'manufacturer_id';

    protected $fillable = [
        'manufacturer',
        'type',
        'color',
    ];

    public function cars()
    {
        return $this->hasMany(Cars::class, 'manufacturer_id');
    }
}
