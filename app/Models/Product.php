<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'guid',
        'product_name',
        'product_description',
        'price',
        'weight',
        'fatAmount',
        'proteinsAmount',
        'carbohydratesAmount',
        'energyAmount',
        'category_id',
        'sort_order',
        'created_at',
        'updated_at',
        'is_disabled',
    ];

    /**
     * @return HasMany
     */
    public function stores()
    {
        return $this->hasMany(Product_to_store::class);
    }

    /**
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany(Product_images::class);
    }
}
