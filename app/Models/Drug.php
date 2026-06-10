<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = [
    'name',
    'category',
    'dosage_form',
    'dosage',  
    'strength',
    'unit_price',
    'contraindications',
]   ;
}
