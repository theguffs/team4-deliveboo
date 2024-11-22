<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'ingredients',
        'image',
        'visible',
        'restaurant_id',
    ];
//creata relazione CON la tabella ristoranti perché più prodotti sono presenti in un singolo ristorante
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
//creata relazione CON la tabella ordini con una PIVOT perché più prodotti possono essere ordinati in più ordini diversi
    public function orders(){
        return $this->belongsToMany(Order::class )->withPivot('quantity');
    }
}
