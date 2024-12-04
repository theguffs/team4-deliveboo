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

    // Relazione con la tabella ristoranti
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Relazione con la tabella ordini con una pivot
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity', 'price')->withTimestamps();
    }

    // Aggiungi un accessor per ottenere l'URL completo dell'immagine
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}