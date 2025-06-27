<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{

    protected $table = 'receipts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'product_id',
        'customer_name',
        'status',
        'estimate',
        'code'
    ];
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    
}
