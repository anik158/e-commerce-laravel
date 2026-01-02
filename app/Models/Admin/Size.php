<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Size extends Model
{
    protected $guarded = ['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'size_product');
    }
}
