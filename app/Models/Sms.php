<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
      'telephone',
      'code',
      'created_at'
    ];
}
