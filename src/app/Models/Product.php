<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Condition;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function condition() {
        return $this->belongsTo(Condition::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function order() {
        return $this->hasOne(Order::class);
    }

    public function scopeKeywordSearch($query, $keyword) {
        if (!empty($keyword)) {
            return $query->where('name', 'like', '%' . $keyword . '%');
        }
    }
}
