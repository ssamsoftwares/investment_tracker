<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallTrade extends Model
{
    use HasFactory;
    protected $fillable = [
        'trade_name','amount','customer_ids'
    ];
}
