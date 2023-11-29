<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',  'first_name', 'last_name','email', 'phone','address', 'city', 'state', 'zip', 'pan_number', 'adhaar_number','status'
    ];

    public function callTrade()
    {
        return $this->hasMany(CallTrade::class, 'customer_ids', 'id');
    }


}
