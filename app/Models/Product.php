<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'stock'];

    // Relación muchos a muchos con Proveedores
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)->withPivot('quantity', 'support', 'date');
    }

    // Relación muchos a muchos con Clientes
    public function clients()
    {
        return $this->belongsToMany(Client::class)->withPivot('quantity', 'support', 'date');
    }
}
