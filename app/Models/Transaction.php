<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tx_ref',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'buyer_email',
        'buyer_name',
        'product_id',
        'seller_id',
    ];
}
