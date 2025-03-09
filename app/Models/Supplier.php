<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['nit', 'email', 'address', 'phone', 'names'];

public function products()
{
    return $this->belongsToMany(Product::class)->withPivot('quantity', 'support', 'date');
}
}
