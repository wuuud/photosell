<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'price'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
