<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'category_product';

    // 主キーなし
    protected $primaryKey = null;
    public $incrementing = false;

    // created_at / updated_at を使う
    public $timestamps = true;

    // 一括代入OK
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
