<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'firstname',
        'lastname',
        'telephone',
        'terminal_guid',
        'comment',
        'total_sum',
        'bonuses',
        'created_at',
        'is_paid',
    ];
}
