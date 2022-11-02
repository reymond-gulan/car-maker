<?php

namespace App\Classes;

use App\Models\Manufacturers;

class ManufacturersHelper
{
    public static function manufacturer($data)
    {
        return Manufacturers::findOrFail($data['manufacturer_id']);
    }
}
