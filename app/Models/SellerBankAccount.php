<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBankAccount extends Model
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_code',
        'account_number',
        'account_name',
        'flutterwave_subaccount_id',
        'is_verified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

