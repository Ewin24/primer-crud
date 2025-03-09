<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'name', 'address', 'email', 'phone', 'dni'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'support', 'date');
    }
}
