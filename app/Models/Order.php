<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'address',
        'price',
        'customer',
        'notes',
        'restaurant_id'
    ];
//creata relazione CON la tabella prodotti con una PIVOT perché più prodotti possono essere ordinati in più ordini diversi
    public function products(){
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity', 'price');
    }
    
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}