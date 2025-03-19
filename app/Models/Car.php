<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    protected $filbale = ['brand', 'model', 'price'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    

}
