<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;

    protected $primaryKey = 'car_id';

    protected $fillable = [
        'car_name',
        'manufacturer_id',
    ];

    public function manufacturers()
    {
        return $this->belongsTo(Manufacturers::class, 'manufacturer_id','manufacturer_id');
    }
}
