<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    Public function plant(){
        return $this->hasMany(Plant::class);
    }
}
