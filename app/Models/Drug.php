<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = [
    'name',
    'category',
    'dosage_form',  // was 'form' in controller — fix the controller too
    'strength',
    'unit_price',
    'contraindications',
]   ;
}
