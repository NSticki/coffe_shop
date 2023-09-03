<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_options extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'option_id',
    ];

    public function GroupOptions($product_id)
    {

    }
}
