<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'description',
        'piva',
        'image',
        'user_id'
    ];
//creata relazione CON tabella users 1TO1 perché UN ristoratore possiende UN ristorante
    public function user(){
        return $this->belongsTo(User::class);
    }
//creata relazione CON tabella categories M to M perché più categorie possono essere assegnate a più ristoranti
    public function categories(){
        return $this->belongsToMany(Category::class, 'restaurant_category');
    } 
//creata relazione CON tabella products 1 to M perché più piatti o prodotti possono essere nello stesso ristorante
    public function products(){
        return $this->hasMany(Product::class);
    }
}
