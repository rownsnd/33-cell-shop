<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Product extends Model
{
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'category_id',
        'product_name',
        'picture',
        'stock',
        'price',
        'description'
    ];

    // Relasi: Product milik satu kategori


    // (opsional) relasi ke user
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    

}
