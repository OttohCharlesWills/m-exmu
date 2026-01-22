<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductApprovalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'seller_id',
        'status',
        'reviewed_at',
        'reviewed_by',
        'admin_note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
