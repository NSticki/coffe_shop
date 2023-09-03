<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option_categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order',
        'parent_id',
        'min_amount',
        'max_amount',
        'required',
        'is_disabled',
        'guid',
    ];

    /**
     * List of children options
     *
     * @return HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
