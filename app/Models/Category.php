<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
//relazione CON tabella ristoranti 1 To M perchè più categorie possono essere assegnate al singolo ristorante
    public function restaurants(){
        return $this->belongsToMany(Restaurant::class);
    } 
}
