<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
      'guid',
      'parent_guid',
      'name',
      'prefix',
      'price',
      'weight',
      'is_disabled'
    ];
}
