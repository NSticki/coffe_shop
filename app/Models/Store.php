<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'store_name',
        'store_address',
        'store_phone',
        'time_from',
        'time_to',
    ];

    public function getId()
    {
        return $this->table->id;
    }
}
