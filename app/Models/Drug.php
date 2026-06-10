<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = [
        'name',
        'category',
        'dosage_form',
        'strength',
        'unit_price',
        'contraindications',
    ];
}
