<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produit extends Model
{
    use HasFactory;
    protected $fillable=['nom','desc','prix','photo','category_id'];

    public function category(){
        //return $this->hasOne(Phone::class);
        return $this->beLongsTo('App\Models\Category');
    }
}

