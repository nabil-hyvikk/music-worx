<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePrice extends Model
{
    protected $table = 'tbl_package_price';
    protected $guarded = [];
    // public function getFormattedPriceInEuroAttribute()
    // {
    //     return '€' . number_format($this->price_in_euro, 2);
    // }
    // public function getFormattedPriceInDollarAttribute()
    // {
    //     return '$' . number_format($this->price_in_dollar, 2);
    // }
}
