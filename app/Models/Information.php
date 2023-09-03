<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'information';

    protected $fillable = [
        'code',
        'title',
        'content',
    ];
}
